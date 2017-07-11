<?php
class HubCo_Feed_Model_Feed
extends Mage_Core_Model_Abstract
{
  var $readCon;
  var $writeCon;
  var $resource;
  var $pdoDb;
  protected function _construct()
  {
    /**
    * This tells Magento where the related resource model can be found.
    *
    * For a resource model, Magento will use the standard model alias -
    * in this case 'hubco_brand' - and look in
    * config.xml for a child node <resourceModel/>. This will be the
    * location that Magento will look for a model when
    * Mage::getResourceModel() is called - in our case,
    * HubCo_Brand_Model_Resource.
    */
    $this->_init('hubco_feed/feed');
    $this->resource = Mage::getSingleton ( 'core/resource' );

    /**
    * Retrieve the read connection
    */
    $this->readCon = $this->resource->getConnection ( 'core_read' );

    /**
    * Retrieve the write connection
    */
    $this->writeCon = $this->resource->getConnection ( 'core_write' );

    $options = array(PDO::MYSQL_ATTR_LOCAL_INFILE => true);
    $local = simplexml_load_file(Mage::getBaseDir() . "/app/etc/local.xml");
    $connection = $local->global->resources->default_setup->connection;
    $this->pdoDb = new PDO(
      "mysql:host={$connection->host};dbname={$connection->dbname}",
      $connection->username,
      $connection->password,
      $options
    );

    $this->pdoDb->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
  }

  public function exportMotorGoogle ($test = false) {

    if ($test != null && $test === true) {
      $fileName = Mage::getStoreConfig ('feed_options/motorgoogle/motor_test' );
      $adGroupFileName = Mage::getStoreConfig ('feed_options/motorgoogle/motor_ad_file');
    }
    else {
      $fileName = Mage::getStoreConfig ('feed_options/motorgoogle/motor_file' );
      $adGroupFileName = Mage::getStoreConfig ('feed_options/motorgoogle/motor_ad_file');
    }
    $count = $this->exportGoogle(Mage::getStoreConfig ('feed_options/motorgoogle/motor_store' ), $fileName, $adGroupFileName, $test);
    Mage::getSingleton('adminhtml/session')->addError(
      Mage::helper('hubco_globalimport')->__("Generated $count Items.")
    );
    // zip and FTP the file to google
    // zip the file before upload
    $zip = new ZipArchive;
    $zipFile = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'.$fileName.".zip";
    if (!$zip->open($zipFile, ZipArchive::CREATE|ZipArchive::OVERWRITE)) {
      Mage::getSingleton('adminhtml/session')->addError(
        Mage::helper('hubco_globalimport')->__("ZipFailed")
      );
    }
    $zip->addFile(Mage::getStoreConfig ('feed_options/feeds/export_dir').'/'.$fileName,$fileName);
    $zip->close();
    // zip the Ad Group file before upload

    $zip = new ZipArchive;
    $zipFile = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'.$adGroupFileName.".zip";
    if (!$zip->open($zipFile, ZipArchive::CREATE|ZipArchive::OVERWRITE)) {
      Mage::getSingleton('adminhtml/session')->addError(
      Mage::helper('hubco_globalimport')->__("ZipFailed")
      );
    }
    $zip->addFile(Mage::getStoreConfig ('feed_options/feeds/export_dir').'/'.$adGroupFileName,$adGroupFileName);
    $zip->close();
    // upload the file to Google
    $conn = ftp_connect(Mage::getStoreConfig ('feed_options/motorgoogle/motor_FTP_server'));
    $login = ftp_login($conn, Mage::getStoreConfig ('feed_options/motorgoogle/motor_FTP_user'), Mage::getStoreConfig ('feed_options/motorgoogle/motor_FTP_pass'));
    if (!$conn || !$login) {
      Mage::getSingleton('adminhtml/session')->addError(
        Mage::helper('hubco_globalimport')->__("Error Connecting to Google, feed not uploaded")
      );
      ftp_close($conn);
    }
    else {
      // upload the file
      $upload = ftp_put($conn, $fileName, $zipFile, FTP_BINARY);
      // check upload status
      if (!$upload) {
        Mage::getSingleton('adminhtml/session')->addError(
          Mage::helper('hubco_globalimport')->__("Google FTP Upload Failed")
        );
      }
      else {
        Mage::getSingleton('adminhtml/session')->addError(
          Mage::helper('hubco_globalimport')->__("File Transmitted to Google")
        );
      }
    }
    ftp_close($conn);
    return "$test, $count, $upload";
  }

  public function exportEdgeGoogle ($test = false) {

    if ($test != null && $test === true) {
      $fileName = Mage::getStoreConfig ('feed_options/edgegoogle/edge_test' );
      $adGroupFileName = Mage::getStoreConfig ('feed_options/edgegoogle/edge_ad_file');
    }
    else {
      $fileName = Mage::getStoreConfig ('feed_options/edgegoogle/edge_file' );
      $adGroupFileName = Mage::getStoreConfig ('feed_options/edgegoogle/edge_ad_file');
    }
    $count = $this->exportGoogle(Mage::getStoreConfig ('feed_options/edgegoogle/edge_store' ), $fileName, $adGroupFileName, $test);
    Mage::getSingleton('adminhtml/session')->addError(
      Mage::helper('hubco_globalimport')->__("Generated $count Items.")
    );
    // zip and FTP the file to google
    // zip the file before upload
    $zip = new ZipArchive;
    $zipFile = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'.$fileName.".zip";
    if (!$zip->open($zipFile, ZipArchive::CREATE|ZipArchive::OVERWRITE)) {
      Mage::getSingleton('adminhtml/session')->addError(
        Mage::helper('hubco_globalimport')->__("ZipFailed")
      );
    }
    $zip->addFile(Mage::getStoreConfig ('feed_options/feeds/export_dir').'/'.$fileName,$fileName);
    $zip->close();
    // zip the Ad Group file before upload

    $zip = new ZipArchive;
    $zipFile = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'.$adGroupFileName.".zip";
    if (!$zip->open($zipFile, ZipArchive::CREATE|ZipArchive::OVERWRITE)) {
      Mage::getSingleton('adminhtml/session')->addError(
      Mage::helper('hubco_globalimport')->__("ZipFailed")
      );
    }
    $zip->addFile(Mage::getStoreConfig ('feed_options/feeds/export_dir').'/'.$adGroupFileName,$adGroupFileName);
    $zip->close();
    // upload the file to Google
    $conn = ftp_connect(Mage::getStoreConfig ('feed_options/edgegoogle/edge_FTP_server'));
    $login = ftp_login($conn, Mage::getStoreConfig ('feed_options/edgegoogle/edge_FTP_user'), Mage::getStoreConfig ('feed_options/edgegoogle/edge_FTP_pass'));
    if (!$conn || !$login) {
      Mage::getSingleton('adminhtml/session')->addError(
        Mage::helper('hubco_globalimport')->__("Error Connecting to Google, feed not uploaded")
      );
      ftp_close($conn);
    }
    else {
      // upload the file
      $upload = ftp_put($conn, $fileName, $zipFile, FTP_BINARY);
      // check upload status
      if (!$upload) {
        Mage::getSingleton('adminhtml/session')->addError(
          Mage::helper('hubco_globalimport')->__("Google FTP Upload Failed")
        );
      }
      else {
        Mage::getSingleton('adminhtml/session')->addError(
          Mage::helper('hubco_globalimport')->__("File Transmitted to Google")
        );
      }
    }
    ftp_close($conn);
    return "$test, $count, $upload";
  }

  public function expl_string($row, $types, $attributes)
  {
    foreach ($types as $type){
      $arr_temp = explode(";|;",$row[$type]);
      foreach ($arr_temp as $arr)
      {
        $arr1 = explode("|",$arr);
        $arr_res[$attributes[$arr1[0]]] = $arr1[1];
      }
    }
    return $arr_res;
  }

  public function substr_word($body,$maxlength){
    if (strlen($body)<$maxlength) return $body;
    $body = substr($body, 0, $maxlength);
    $rpos = strrpos($body,' ');
    if ($rpos>0) $body = substr($body, 0, $rpos);
    return $body;
  }

  public function sentence_case($string) {
    $sentences = preg_split('/([.?!\n]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    $new_string = '';
    foreach ($sentences as $key => $sentence) {
      $new_string .= ($key & 1) == 0?
      ucfirst(strtolower(trim($sentence))) :
      $sentence.' ';
    }
    return trim($new_string);
  }

  public function exportGoogle($storeId, $url, $url2, $test)
  {
    $store = Mage::app()->getStore($storeId);
    $brands = Mage::getModel('hubco_brand/brand')->getAvailableBrands();

    $name='color';
    $attributeModel = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $name);
    $options = $attributeModel->getSource()->getAllOptions(false);
    $colors = array();
    foreach ($options as $row) {
      $colors[$row['value']] = $row['label'];
    }
    $name='size';
    $attributeModel = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $name);
    $options = $attributeModel->getSource()->getAllOptions(false);
    $sizes = array();
    foreach ($options as $row) {
      $sizes[$row['value']] = $row['label'];
    }
    $name='gender';
    $attributeModel = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $name);
    $options = $attributeModel->getSource()->getAllOptions(false);
    $genders = array();
    foreach ($options as $row) {
      $genders[$row['value']] = $row['label'];
    }
    $name='age';
    $attributeModel = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $name);
    $options = $attributeModel->getSource()->getAllOptions(false);
    $ages = array();
    foreach ($options as $row) {
      $ages[$row['value']] = $row['label'];
    }

    $country = 'US';  // use short country code
    $region = '23';   // must be numeric!
    $postcode = '60062';

    // our quote extension stores the customer id ('2') which we use to get the tax class
    $customer = Mage::getModel('customer/customer')->load( '2' );
    $custTax = $customer->getTaxClassId();

    $TaxRequest  = new Varien_Object();
    $TaxRequest->setCountryId( $country );
    $TaxRequest->setRegionId( $region );
    $TaxRequest->setPostcode( $postcode );
    $TaxRequest->setStore( Mage::app()->getStore() );
    $TaxRequest->setCustomerClassId( $custTax );
    $TaxRequest->setProductClassId(2);  // 2=taxable id (all our products are taxable)

    $taxCalculationModel = Mage::getSingleton('tax/calculation');
    $taxRate = $taxCalculationModel->getRate($TaxRequest);


    //   $base_url = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    $base_url = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    $media_url = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
    $types = array ('Integer','Text','Varchar','Decimal','Media');
    $url = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'. $url;
    $url2 = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'. $url2;

    $attributesInfo = Mage::getResourceModel('eav/entity_attribute_collection')
    ->setEntityTypeFilter('4')  //4 = Default - набор атрибутов
    ->addSetInfo()
    ->getData();

    $needed_attribute_codes = array('brand_id','name', 'description', 'url_key', 'image', 'price','map_price',
      'tax_class_id', 'weight', 'google_taxonomy', 'upc', 'mpn', 'color', 'size', 'gender','google_active');
    $needed_attribute_ids = array();
    $needed_attributes = array();
    $google_attribute_id;
    foreach($attributesInfo as $attribute) {
      $attribute = Mage::getModel('eav/entity_attribute')->load($attribute['attribute_id']);
      if (in_array($attribute['attribute_code'], $needed_attribute_codes))
      {
        $needed_attribute_ids[] = $attribute['attribute_id'];
        $needed_attributes[$attribute['attribute_id']] = $attribute['attribute_code'];
        //$needed_attributes[$attribute['attribute_code']] = $attribute['attribute_id'];
      }
    }

    $fh = fopen($url, "w");
    if ($fh === false) {
      return "File Open Error";
    }

    //fill out second file with ad groups for google
    if ($storeId == Mage::getStoreConfig ('feed_options/motorgoogle/motor_store' )) {
      $numberProdInGroup = Mage::getStoreConfig ('feed_options/motorgoogle/motor_ad_num');
      $cpcValue =  Mage::getStoreConfig ('feed_options/motorgoogle/motor_ad_cpc');
      $campaignName = Mage::getStoreConfig ('feed_options/motorgoogle/motor_ad_name');
    }
    else {
      $numberProdInGroup = Mage::getStoreConfig ('feed_options/edgegoogle/edge_ad_num');
      $cpcValue =  Mage::getStoreConfig ('feed_options/edgegoogle/edge_ad_cpc');
      $campaignName = Mage::getStoreConfig ('feed_options/edgegoogle/edge_ad_name');
    }

    $fh2 = fopen($url2, "w");
    if ($fh2 === false) {
      return "File Open Error";
    }

    //header of file 2
    $header = array('Campaign','Ad Group', 'Max CPC', 'Product Group');
    $strAdGroupArray = array();

      foreach ($header as $val)
    {
      $strAdGroupArray [$val]= ' ';
    }

    $error = fputcsv($fh2, $header);

    fwrite ($fh, '<?xml version="1.0"?> <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"> <channel>'.PHP_EOL);

    $needed_ids = implode(',', $needed_attribute_ids);
    $websiteID = $store->getWebsiteId();
    $query = "SET SESSION group_concat_max_len = 8192";
    $this->pdoDb->query($query);
    $query = "SELECT  P.*, S.*, PR.*,
    GROUP_CONCAT(DISTINCT CONCAT(D.attribute_id, '|', D.`value`) SEPARATOR ';|;') AS 'Decimal',
    GROUP_CONCAT(DISTINCT CONCAT(I.attribute_id, '|', I.`value`) SEPARATOR ';|;') as 'Integer',
    GROUP_CONCAT(DISTINCT CONCAT(T.attribute_id, '|', T.`value`) SEPARATOR ';|;') as 'Text',
    GROUP_CONCAT(DISTINCT CONCAT(V.attribute_id, '|', V.`value`) SEPARATOR ';|;') as 'Varchar',
    GROUP_CONCAT(DISTINCT CONCAT(M.attribute_id, '|', M.`value`) SEPARATOR ';|;') as 'Media'
    FROM
      (`catalog_product_entity` P,
      `cataloginventory_stock_item` S,
      `catalog_product_index_price` PR)
      LEFT JOIN `catalog_product_entity_decimal` D ON P.entity_id = D.entity_id
        AND D.attribute_id IN ($needed_ids)
      LEFT JOIN `catalog_product_entity_int` I ON I.entity_id =  P.entity_id
        AND I.attribute_id IN ($needed_ids)
      LEFT JOIN `catalog_product_entity_text` T ON T.entity_id = P.entity_id
        AND T.attribute_id IN ($needed_ids)
      LEFT JOIN `catalog_product_entity_varchar` V ON V.entity_id = P.entity_id
        AND V.attribute_id IN ($needed_ids)
      LEFT JOIN `catalog_product_entity_media_gallery` M ON  M.entity_id = P.entity_id
    WHERE S.product_id = P.entity_id
    AND P.entity_id =  PR.entity_id
    AND S.qty > 0
    AND PR.website_id = $websiteID
    AND PR.customer_group_id = 0
    GROUP BY P.sku
    ";
    $i = 0;
    foreach ($this->pdoDb->query($query) as $row) {

      $row = array_merge($row, $this->expl_string($row, $types, $needed_attributes));
      // skip any products that we should not send to google
      if ($row['google_active'] != 1) {continue;}
      if ($row['price'] < 1) {continue;}
      if (empty($row['image'])) {continue;}
      $i++;
      fwrite ($fh, "<item>".PHP_EOL);
      fwrite ($fh, "<g:id>".$row['sku']."</g:id>".PHP_EOL);

      $title = $row['name'];
      if ((strlen($title)+strlen($brands[$row['brand_id']])) < 70) { $title = $brands[$row['brand_id']]." ".$title;}
      if (!empty($row['color']) && (strlen($title)+strlen($prod['color'])) < 70) {$title .= " " . $prod['color'];}
      if (!empty($row['size']) && (strlen($title)+strlen($prod['size'])) < 70) {$title .= " " . $prod['size'];}
      if ((strlen($title)+strlen($row['mpn'])) < 70) { $title .= " " . $row['mpn']; }
      $title = htmlspecialchars(strip_tags(ucwords(strtolower(substr($title,0,70)))));
      fwrite ($fh, "<title>$title</title>".PHP_EOL);

      if (($row['description'] == null) OR ($row['description'] == "<UL></UL>") OR ($row['description'] == "0"))
      {
        $row['description'] = $row['name']." By ".$brands[$row['brand_id']];
      }
      fwrite ($fh, "<description>".$this->substr_word(htmlspecialchars($this->sentence_case(strip_tags(strtolower($row['description'])))), 2500)."</description>".PHP_EOL);


      fwrite ($fh, "<link>".$base_url.$row['url_key'].".html</link>".PHP_EOL);

      fwrite ($fh, "<g:image_link>".$media_url."catalog/product".$row['image']."</g:image_link>".PHP_EOL);

      fwrite ($fh, "<g:condition>new</g:condition>".PHP_EOL);

      fwrite ($fh, "<g:price>".trim(Mage::helper('core')->formatPrice($row['price'], false),'$')."</g:price>".PHP_EOL);

      fwrite ($fh, "<g:tax>US:IL:$taxRate:n</g:tax>".PHP_EOL);

      if ($row['weight'] != NULL or $row['weight'] != '')
      {
        fwrite ($fh, "<g:shipping_weight>".$row['weight']."</g:shipping_weight>".PHP_EOL);
      }
      elseif (!$test) {
        fwrite ($fh, "<g:shipping_weight>"."1"."</g:shipping_weight>".PHP_EOL);
      }

      if ($row['price'] >= 75 )
      {
        fwrite ($fh, "<g:shipping><g:country>US</g:country><g:service>Ground</g:service><g:price>0.00 USD</g:price></g:shipping>".PHP_EOL);
      }

      if($row['qty']>0)
      {
        fwrite ($fh, "<g:availability>in stock</g:availability>".PHP_EOL);
      }
      else {
        fwrite ($fh, "<g:availability>out of stock</g:availability>".PHP_EOL);
      }

      fwrite ($fh, "<g:google_product_category>".htmlspecialchars(strip_tags(htmlspecialchars_decode($row['google_taxonomy'])))."</g:google_product_category>".PHP_EOL);

      fwrite ($fh, "<g:brand>".htmlspecialchars($brands[$row['brand_id']])."</g:brand>".PHP_EOL);

      fwrite ($fh, "<g:mpn>".htmlspecialchars($row['mpn'])."</g:mpn>".PHP_EOL);

      $apparel = strstr($row['google_taxonomy'], 'Apparel') !== false;

      if ($row['color']!= NULL or $row['color'] != '')
      {
        fwrite ($fh, "<g:color>".htmlspecialchars($colors[$row['color']])."</g:color>".PHP_EOL);
      }
      elseif($apparel && !$test) {
        fwrite ($fh, "<g:color>".htmlspecialchars('Multicolor')."</g:color>".PHP_EOL);
      }

      if ($row['size']!= NULL or $row['size'] != '')
      {
        fwrite ($fh, "<g:size>".htmlspecialchars($sizes[$row['size']])."</g:size>".PHP_EOL);
      }
      elseif($apparel && !$test) {
        fwrite ($fh, "<g:size>".htmlspecialchars('One Size fits Most')."</g:size>".PHP_EOL);
      }

      if ($row['gender']!= NULL or $row['gender'] != '')
      {
        fwrite ($fh, "<g:gender>".htmlspecialchars($genders[$row['gender']])."</g:gender>".PHP_EOL);
      }
      elseif($apparel && !$test) {
        fwrite ($fh, "<g:gender>".htmlspecialchars('Unisex')."</g:gender>".PHP_EOL);
      }

      if ($row['age']!= NULL or $row['age'] != '')
      {
        fwrite ($fh, "<g:age_group>".htmlspecialchars($ages[$row['age']])."</g:age_group>".PHP_EOL);
      }
      elseif($apparel && !$test) {
        fwrite ($fh, "<g:age_group>".htmlspecialchars('adult')."</g:age_group>".PHP_EOL);
      }

      if ($row['upc']!= NULL or $row['upc'] != '')
      {
        fwrite ($fh, "<g:gtin>".$row['upc']."</g:gtin>".PHP_EOL);
      }

      //<g:custom_label_0>
      fwrite($fh, "<g:custom_label_0>");
      if ($row['price'] < 25) fwrite($fh, '&lt;$0025');
      elseif ($row['price'] < 50) fwrite($fh, '&lt;$0050');
      elseif ($row['price'] < 75) fwrite($fh, '&lt;$0075');
      elseif ($row['price'] < 100) fwrite($fh, '&lt;$0100');
      elseif ($row['price'] < 150) fwrite($fh, '&lt;$0150');
      elseif ($row['price'] < 200) fwrite($fh, '&lt;$0200');
      elseif ($row['price'] < 250) fwrite($fh, '&lt;$0250');
      elseif ($row['price'] < 300) fwrite($fh, '&lt;$0300');
      elseif ($row['price'] < 350) fwrite($fh, '&lt;$0350');
      elseif ($row['price'] < 400) fwrite($fh, '&lt;$0400');
      elseif ($row['price'] < 450) fwrite($fh, '&lt;$0450');
      elseif ($row['price'] < 500) fwrite($fh, '&lt;$0500');
      elseif ($row['price'] < 600) fwrite($fh, '&lt;$0600');
      elseif ($row['price'] < 700) fwrite($fh, '&lt;$0700');
      elseif ($row['price'] < 800) fwrite($fh, '&lt;$0800');
      elseif ($row['price'] < 900) fwrite($fh, '&lt;$0900');
      elseif ($row['price'] < 1000) fwrite($fh, '&lt;$1000');
      elseif ($row['price'] < 1200) fwrite($fh, '&lt;$1200');
      elseif ($row['price'] < 1400) fwrite($fh, '&lt;$1400');
      elseif ($row['price'] < 1600) fwrite($fh, '&lt;$1600');
      elseif ($row['price'] < 1800) fwrite($fh, '&lt;$1800');
      elseif ($row['price'] < 2000) fwrite($fh, '&lt;$2000');
      elseif ($row['price'] < 2500) fwrite($fh, '&lt;$2500');
      elseif ($row['price'] < 3000) fwrite($fh, '&lt;$3000');
      elseif ($row['price'] < 3500) fwrite($fh, '&lt;$3500');
      elseif ($row['price'] < 4000) fwrite($fh, '&lt;$4000');
      else fwrite($fh, '&gt;$4000+');
      fwrite($fh, "</g:custom_label_0>".PHP_EOL);

      // custom label for margin
      fwrite($fh, "<g:custom_label_1>");
      $margin = $row['price'] * .1;
      if ($margin<-98) fwrite($fh, "-99\$M");
      elseif ($margin<-75) fwrite($fh, "-98-&gt;-75\$M");
      elseif ($margin<-50) fwrite($fh, "-74-&gt;-50\$M");
      elseif ($margin<-25) fwrite($fh, "-49-&gt;-25\$M");
      elseif ($margin<-5) fwrite($fh, "-24-&gt;-5\$M");
      elseif ($margin<0) fwrite($fh, "-4-&gt;0\$M");
      elseif ($margin<5) fwrite($fh, "0-&gt;4\$M");
      elseif ($margin<10) fwrite($fh, "5-&gt;10\$M");
      elseif ($margin<20) fwrite($fh, "11-&gt;20\$M");
      elseif ($margin<30) fwrite($fh, "21-&gt;30\$M");
      elseif ($margin<40) fwrite($fh, "31-&gt;40\$M");
      elseif ($margin<50) fwrite($fh, "41-&gt;50\$M");
      elseif ($margin<75) fwrite($fh, "51-&gt;75\$M");
      elseif ($margin<100) fwrite($fh, "76-&gt;100\$M");
      else fwrite($fh, "100-&gt;\$M");
      fwrite($fh, "</g:custom_label_1>".PHP_EOL);

      // custom label for MAP
      fwrite($fh, "<g:custom_label_3>");
      fwrite($fh, $prod['map_price']==0 || empty($prod['map_price'])?'Not Mapped':'Mapped');
      fwrite($fh, "</g:custom_label_3>".PHP_EOL);

      fwrite ($fh, "</item>".PHP_EOL);

      // write the adwords file data
      $sessionNum = ceil($row['entity_id']/$numberProdInGroup);
      $strAdGroupArray['Product Group'] = '* /';
      $strAdGroupArray['Campaign'] = $campaignName.$sessionNum;
      $strAdGroupArray['Ad Group'] = $row['sku']."-".$row['url_key'];
      $strAdGroupArray['Max CPC'] = '';
      fputcsv($fh2, $strAdGroupArray);
      $strAdGroupArray['Product Group'] = "* / Item ID='".$row['sku']."'";
      $strAdGroupArray['Campaign'] = $campaignName.$sessionNum;
      $strAdGroupArray['Ad Group'] = $row['sku']."-".$row['url_key'];
      $strAdGroupArray['Max CPC'] = $cpcValue;
      fputcsv($fh2, $strAdGroupArray);
      $strAdGroupArray['Product Group'] = "* / Item ID=*";
      $strAdGroupArray['Campaign'] = $campaignName.$sessionNum;
      $strAdGroupArray['Ad Group'] = $row['sku']."-".$row['url_key'];
      $strAdGroupArray['Max CPC'] = 'Excluded';
      fputcsv($fh2, $strAdGroupArray);

    }

    fwrite ($fh, '</channel> </rss>'.PHP_EOL);

    return $i;
  }

}