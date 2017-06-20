<?php
require_once 'config.php';
require_once 'class/employee_c.php';
$employee = new Employee();

if (!$employee->IsLoggedIn() && stripos(IPS, $_SERVER['REMOTE_ADDR']) === false) {
  echo "denied!";
  exit;
}

if (extension_loaded('newrelic')) {
  newrelic_set_appname ('HUBCron');
  newrelic_name_transaction('GoogleFeed');
  newrelic_capture_params (  );
}

  require_once 'class/product_c.php';
  require_once 'class/coupon_c.php';
  set_time_limit(0);
  ob_end_flush();
  echo "<pre>";
  $coupon = new Coupon();
  $autoC = $coupon->GetAutoCoupons();
  // get rid of any AutoCoupons that are not for shipping
  foreach ($autoC as $key=>$coup) {
    if ($coup['shipPerc'] != 100 || $coup['expShipPerc'] != 100) {
      unset($autoC[$key]);
    }
  }

  $product = new Product();
  global $site;
  $query = $product->GetProductsForFeed(null, 'CS');
  $fh = fopen(SITE_ROOT."/feeds/ChannelSale.csv", "w");
  if ($fh === false) {
    echo "file Open Error";
    return;
  }
  fwrite($fh,"UniqueRetailerID,SKU,ProductTitle,LongDescription,ShortDescription,Brand,ManufacturerModel,MPN,UPC,EAN,OtherReferenceNumber,MerchantCategory,Retailer Price,AMZ MIN PRICE,AMZ MAX PRICE,ImageURL,StockQuantity,ProductURL,Weight,Length,Width,Height,neweggCat,searsCat,jetCat,googleCat,amazonCat,PriceFallsCat,Condition,priceDisc,cost,MSRP,MAPPED,ASIN,ITkeyword,labels,IsFreeShipping,color,size,gender,genderSears,isAmazon,isRakuten,isNewegg,isSears,isJet,isWalmart,Fulfilment Latency,Product Tax Code,ACA Brand\n");
  $linecount = 0;
  while ($prod = $product->GetNextForFeed($query)) {
      $linecount ++;
      $apparel = strstr(sentence_case($prod['taxonomyGoogle']), 'Apparel');
      $brand = htmlspecialchars($prod['brandName']);
      $name = htmlspecialchars($prod['name']);
      $title = $name;
      if ((strlen($title)+strlen($brand)) < 70) {
        $title = $brand . " " . $title;
      }
      if ((strlen($title)+strlen($prod['modelNum'])) < 70) {
        $title = $title . " " . $prod['modelNum'];
      }
      $title = htmlspecialchars(strip_tags(ucwords(strtolower(substr($title,0,70)))));
      $description = substr_word(htmlspecialchars(sentence_case(strip_tags($prod['description']))), 2000);
      $shortDescription = substr_word(htmlspecialchars(sentence_case(strip_tags($prod['shortDescription']))), 500);
      if (empty($shortDescription)) {$shortDescription = substr_word(htmlspecialchars(sentence_case(strip_tags($prod['description']))), 500);}
      $keyword = htmlspecialchars(strip_tags($prod['ItemTypeKeyword']));
      $category = htmlspecialchars(strip_tags($prod['path']));
      $url = htmlspecialchars(strip_tags($prod['url']));
      $mpn = htmlspecialchars(strip_tags($prod['modelNum']));
      $price = $prod['MAP']==0||$prod['MAP']<$prod['price']?$prod['price']:$prod['MAP'];
      if ($prod['brandID'] == 479) {
        $price = $price *.98;
      }
      $cost = (($prod['cost'])+$prod['shipEstimate'])/.85;
      $minPrice = (($prod['cost']*(1+AMZ_MIN_PROFIT/300))+$prod['shipEstimate'])/.85;
      if (strpos($prod['suppliers'], 'thehubcompanies') !== false) {
        // discount if a product in in stock by us
        $price = $price * .95;
        $cost = $cost * .95;
      }
      if (!empty($prod['channelPrice']) && $prod['channelPrice'] > 0) {
        $price = max($prod['channelPrice'], $minPrice);
      }
      $price = max($price, $cost, $minPrice);
      //echo $prod['productID']. " | " .$cost ." || " . $price;
      $priceDisc = max($prod['price'], $cost);
      $maxPrice = $price*1.3;
      $labels = 'All Inventory';
      if ($prod['amazon'] == 1 && $prod['Bamazon'] == 1 && $prod['noAuth'] == 0 && (!empty($prod['ASIN']) || !empty($prod['UPC'])) && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        $labels .= ',Amazon Seller Central - US';
      }
      else {
        $labels .= ',-Amazon Seller Central - US';
      }
      if ($prod['cost'] > 0 && $prod['MAP'] == 0) {
        $labels .= ',Repricer1';
      }
      else {
        $labels .= ',-Repricer1';
      }
      if ($prod['amazon'] == 1 && $prod['rakuten'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        $labels .= ",Rakuten.com Shopping";
      }
      else {
        $labels .= ",-Rakuten.com Shopping";
      }
      if ($prod['amazon'] == 1 && $prod['newegg'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        $labels .= ",Newegg Inventory";
      }
      else {
        $labels .= ",-Newegg Inventory";
      }
      if ($prod['amazon'] == 1 && $prod['sears'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        $labels .= ",Sears Inventory";
      }
      else {
        $labels .= ",-Sears Inventory";
      }
      if ($prod['amazon'] == 1 && $prod['jet'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        $labels .= ",Jet.com";
      }
      else {
        $labels .= ",-Jet.com";
      }
      //echo $labels . "<br>";
      // need to determine if free shipping coupons will apply
      // run through the coupons checking for exclusions and min spend
      $freeShip = false;
      if ($prod['freeShipping'] == 1) {
        $freeShip = true;
      } else {
        // Double check by going through coupons
        foreach ($autoC as $coupon) {
          if ($price < $coupon['minSpend']) {continue;} // price
          // brand excluded
          if (isset($coupon['BarrE'][$prod['brandID']])) {continue;}
          // brand Required
          if (!empty($coupon['BarrR']) && !isset($coupon['BarrR'][$prod['brandID']])) {continue;}

          // product excluded
          if (isset($coupon['ParrE'][$prod['productID']])) {continue;}
          // product required
          if (!empty($coupon['ParrR']) && !isset($coupon['ParrR'][$prod['productID']])) {continue;}

          $categories = explode(' > ',$prod['pathID']);
          $catR = false;
          foreach ($categories as $cat) {
            // category excluded
            if (isset($coupon['CarrE'][$cat])) {continue 2;}
            // category Required
            if (!empty($coupon['CarrR']) && !isset($coupon['CarrR'][$cat])) {$catR = true;}
          }
          if (!$catR) { continue; }
          $freeShip = true;
          if ($freeShip) {break;}
        }
      }

      if ($prod['qtyAvailable'] > 0)
        $availability = "in stock";
      else
        $availability = "out of stock";

      fwrite($fh,"{$prod['productID']}");
      fwrite($fh,",{$prod['productID']}");
      fwrite($fh,",\"$title\"");
      if (empty($description)) {
        fwrite($fh,",\"$title\"");
      }
      else {
        fwrite($fh,",\"$description\"");
      }
      if (empty($shortDescription)) {
        fwrite($fh,",\"$title\"");
      }
      else {
        fwrite($fh,",\"$shortDescription\"");
      }
      fwrite($fh,",\"$brand\"");
      fwrite($fh,",\"$mpn\"");
      fwrite($fh,",\"$mpn\"");

       if (strlen($prod['UPC']) == 12) {
         fwrite($fh,",{$prod['UPC']}");
         fwrite($fh,",");
         fwrite($fh,",");
       }
       elseif (strlen($prod['UPC']) == 13) {
         fwrite($fh,",");
         fwrite($fh,",{$prod['UPC']}");
         fwrite($fh,",");
       } else {
         fwrite($fh,",");
         fwrite($fh,",");
         fwrite($fh,",{$prod['UPC']}");
       }

      fwrite($fh,",\"$category\"");
      fwrite($fh,",".sprintf("%01.2f", $price)); // price
      if ($prod['MAP']==0) {
        fwrite($fh,",".sprintf("%01.2f", $minPrice)); // minPrice
        fwrite($fh,",".sprintf("%01.2f", $maxPrice)); // maxPrice
      }
      else {
        fwrite($fh,",".sprintf("%01.2f", $price)); // minPrice
        fwrite($fh,",".sprintf("%01.2f", $price*1.5)); // maxPrice
      }

      if (!empty($prod['imageUrl'])) {
        fwrite($fh,",".WEB_ADDRESS."/images/prod/{$prod['imageUrl']}");
      }
      else {
        fwrite($fh,",");
      }
      fwrite($fh,",{$prod['qtyAvailable']}");
      fwrite($fh,",".WEB_ADDRESS."/$url");
      if (empty($prod['packWeight']) || $prod['packWeight'] == 0) {
        fwrite($fh,",1.00");
      }
      else {
        fwrite($fh,",".sprintf("%01.2f", $prod['packWeight']));
      }
      if (empty($prod['packHeight']) || $prod['packHeight'] == 0) {
        fwrite($fh,",1.00");
      }
      else {
        fwrite($fh,",".sprintf("%01.2f", $prod['packHeight']));
      }
      if (empty($prod['packLength']) || $prod['packLength'] == 0) {
        fwrite($fh,",1.00");
      }
      else {
        fwrite($fh,",".sprintf("%01.2f", $prod['packLength']));
      }
      if (empty($prod['packWidth']) || $prod['packWidth'] == 0) {
        fwrite($fh,",1.00");
      }
      else {
        fwrite($fh,",".sprintf("%01.2f", $prod['packWidth']));
      }
      fwrite($fh,",{$prod['taxonomyNewEgg']}");
      fwrite($fh,",{$prod['taxonomySears']}");
      fwrite($fh,",{$prod['jetCat']}");
      fwrite($fh,",\"{$prod['taxonomyGoogle']}\"");
      $amazonCat = '';
      if (stripos($category, 'wheel') !== false || stripos($category, 'tire') !== false) {
        $amazonCat = 'Tires and Wheels';
      }
      elseif ($apparel) {
        $amazonCat = 'Clothing';
      }
      else {
        $amazonCat = 'Automotive';
      }
      fwrite($fh,",\"$amazonCat\"");
      fwrite($fh,",{$prod['priceFallsCat']}");
      fwrite($fh,",New");
      fwrite($fh,",".sprintf("%01.2f", $priceDisc));
      fwrite($fh,",".sprintf("%01.2f", $cost));
      fwrite($fh,",".sprintf("%01.2f", $prod['MSRP']+($prod['MAP']>0?1:0)*$prod['shipEstimate']));
      $mapPrice = $prod['MAP']+($prod['MAP']>0?1:0)*$prod['shipEstimate'];
      fwrite($fh,",".$mapPrice);
      fwrite($fh,",{$prod['ASIN']}");
      fwrite($fh,",\"$keyword\"");
      fwrite($fh,",\"$labels\"");
      if ($freeShip) {
        fwrite($fh,",TRUE");
      }
      else {
        fwrite($fh,",FALSE");
      }

      if (!empty($prod['color'])) {
        $color = $title = htmlspecialchars(strip_tags($prod['color']));
        fwrite($fh,",\"$color\"");
      }
      else {
        fwrite($fh,",");
      }
      if (!empty($prod['size'])) {
        $size = $title = htmlspecialchars(strip_tags($prod['size']));
        fwrite($fh,",\"$size\"");
      }
      else {
        fwrite($fh,",s");
      }
      if ($apparel) {
        switch (trim($prod['gender'])) {
          case 'Youth':
          case 'Y':
          case 'Kids':
            $gender = "unisex-child";
            $genderS = "Unisex";
            break;
          case 'Infant':
          case 'Toddler':
            $gender = "unisex-baby";
            $genderS = "Unisex";
            break;
          case 'Youth Boy':
            $gender = "boys";
            $genderS = "Boys";
            break;
          case 'Youth Girl':
            $gender = "girls";
            $genderS = "Girls";
            break;
          case 'W':
          case 'Women':
          case 'Womens':
            $gender = 'womens';
            $genderS = "Women";
            break;
          case 'Unisex':
          case 'Mens/Unisex';
            $gender = 'unisex-adult';
            $genderS = "Unisex";
            break;
          case 'Men':
          case 'M':
          case 'Mens':
          default:
            $gender = 'mens';
            $genderS = "Men";
            break;
        }
        fwrite($fh,",$gender");
        fwrite($fh,",$genderS");
      }
      else {
        fwrite($fh,",");
        fwrite($fh,",");
      }
      // List of Not for each channel
      if ($prod['amazon'] == 1 && $prod['Bamazon'] == 1 && $prod['noAuth'] == 0 && (!empty($prod['ASIN']) || !empty($prod['UPC'])) && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        fwrite($fh,",yes");
      }
      else {
        fwrite($fh,",no");
      }
      if ($prod['rakuten'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        fwrite($fh,",yes");
      }
      else {
        fwrite($fh,",no");
      }
      if ( $prod['newegg'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        fwrite($fh,",yes");
      }
      else {
        fwrite($fh,",no");
      }
      if ($prod['sears'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0) {
        fwrite($fh,",yes");
      }
      else {
        fwrite($fh,",no");
      }
      if ($prod['jet'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0 && !empty($prod['imageUrl'])) {
        fwrite($fh,",yes");
      }
      else {
        fwrite($fh,",no");
      }
      if ($prod['walmart'] == 1 && $prod['noAuth'] == 0 && !empty($prod['approvedDate']) && $prod['cost'] > 0 && !empty($prod['imageUrl'])) {
        fwrite($fh,",yes");
      }
      else {
        fwrite($fh,",no");
      }
      // Fulfilment Latency
      fwrite($fh,",3");
      // product tax code
      fwrite($fh,",2048305");
      //ACA Brand ID
      fwrite($fh,",".$prod['ACABrand']);
      fwrite($fh,"\n");
  }
  // upload the file to Channel Advisor 1
  $conn = ftp_connect("54.235.87.53");
  $login = ftp_login($conn, 'eugene.lorman@gmail.com', 'Diamonizer1!@#');
  if (!$conn || !$login) {
    error_log("Error Connecting to Channel Sale 1, feed not uploaded");

    echo "Error Connecting to Channel Sale 1, feed not uploaded";
    ftp_close($conn);
    exit;
  }

  // zip the file before upload
//   $zip = new ZipArchive;
//   $zipFile = SITE_ROOT."/feeds/cs.zip";
//   if (!$zip->open($zipFile, ZipArchive::CREATE|ZipArchive::OVERWRITE)) {
//     error_log("ZipFailed");
//     echo "ZipFailed";
//   }
//   $zip->addFile(SITE_ROOT."/feeds/ChannelSale.csv","ChannelSale.csv");
//   $zip->close();

  // upload the file to Channel Advisor 1
//  $upload = ftp_put($conn, "/cs.zip", SITE_ROOT."/feeds/cs.zip", FTP_BINARY);
  $upload = ftp_put($conn, "/ChannelSale.csv", SITE_ROOT."/feeds/ChannelSale.csv", FTP_BINARY);
  var_dump($upload);
  // check upload status
  if (!$upload) {
    error_log("Uploaded to ChannelSale");
    echo "Uploaded to ChannelSale";
  }
  // close the FTP stream
  ftp_close($conn);

  function sentence_case($string) {
    $sentences = preg_split('/([.?!\n]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    $new_string = '';
    foreach ($sentences as $key => $sentence) {
        $new_string .= ($key & 1) == 0?
            ucfirst(strtolower(trim($sentence))) :
            $sentence.' ';
    }
    return trim($new_string);
  }

  function substr_word($body,$maxlength){
    if (strlen($body)<$maxlength) return $body;
    $body = substr($body, 0, $maxlength);
    $rpos = strrpos($body,' ');
    if ($rpos>0) $body = substr($body, 0, $rpos);
    return $body;
  }

  function validate_UPCABarcode($barcode){
    // check to see if barcode is 12 digits long
    if(!preg_match("/^[0-9]{12}$/",$barcode)) {
      return false;
    }
    $digits = $barcode;
    // 1. sum each of the odd numbered digits
    $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
    // 2. multiply result by three
    $odd_sum_three = $odd_sum * 3;
    // 3. add the result to the sum of each of the even numbered digits
    $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9];
    $total_sum = $odd_sum_three + $even_sum;
    // 4. subtract the result from the next highest power of 10
    $next_ten = (ceil($total_sum/10))*10;
    $check_digit = $next_ten - $total_sum;
    // if the check digit and the last digit of the barcode are OK return true;
    if($check_digit == $digits[11]) {
       return true;
    }
    return false;
  }

  $GLOBALS['gDb']->DbDisconnect();
  ob_flush();
?>
