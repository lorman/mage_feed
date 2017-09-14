<?php
class HubCo_Feed_Model_FeedAll
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
    $this->_init('hubco_feed/feedAll');
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

  public function export() {
    $this->exportAll(Mage::getStoreConfig ('feed_options/all/all_store' ), Mage::getStoreConfig ('feed_options/all/all_file' ));

    // upload the file to Google
    $conn = ftp_connect(Mage::getStoreConfig ('feed_options/all/all_FTP_server'));
    $login = ftp_login($conn, Mage::getStoreConfig ('feed_options/all/all_FTP_user'), Mage::getStoreConfig ('feed_options/all/all_FTP_pass'));
    if (!$conn || !$login) {
      Mage::getSingleton('adminhtml/session')->addError(
        Mage::helper('hubco_globalimport')->__("Error Connecting to Google, feed not uploaded")
      );
      ftp_close($conn);
    }
    else {
      // upload the file
      $url = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'. Mage::getStoreConfig ('feed_options/all/all_file' );
      $upload = ftp_put($conn, Mage::getStoreConfig ('feed_options/all/all_file' ), $url, FTP_BINARY);
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

  public function exportAll($storeId, $url)
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

    //$base_url = Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    $base_url = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
    $media_url = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

    /////// categories
    $allCategoriesCollection = Mage::getModel ( 'catalog/category' )->getCollection ()
    ->addAttributeToSelect ( 'name' )
    ->addAttributeToSelect ( 'category_hub_google_category' )
    ->addAttributeToSelect ( 'category_hub_jet_category' )
    ->addAttributeToSelect ( 'category_hub_new_egg_cat' )
    ->addAttributeToSelect ( 'category_hub_pricefalls' )
    ->addAttributeToSelect ( 'category_hub_walgreens_cat' )
    ->addAttributeToSelect ( 'category_hub_sears_category' )
    ->addAttributeToSelect ( 'category_hub_positive_keywords' )
    ->addAttributeToSelect ( 'category_hub_negative_keywords' )->addFieldToFilter ( 'level', array (
      'gt' => '1'
    ) );
    $allCategoriesArray = $allCategoriesCollection->load ()->toArray ();
    // fill in the text path for each category
    $buildPath = array();
    foreach ($allCategoriesArray as $cat) {
      $buildPath[$cat['entity_id']] = $cat['name'];
    }
    foreach ($allCategoriesArray as  $key => $cat)
    {
      $category = Mage::getModel('catalog/category')
      ->setStoreId(Mage::app()->getStore()->getId())
      ->load($cat['entity_id']);
      $google_taxonomy = $category->getResource()->getAttribute('category_hub_google_category')->getFrontend()->getValue($category);
      $path = explode('/', $cat['path']);
      $string = '';
      foreach ($path as $pathId)
      {
        if (isset($buildPath[$pathId]))
          $string.= $buildPath[$pathId] . '/';
      }
      $string = trim($string, '/');
      $allCategoriesArray[$key]['pathStr'] = addslashes($string);
      $allCategoriesArray[$key]['google_taxonomy'] = $google_taxonomy;
      $allCategoriesArray[$key]['jet_category'] = $category->getResource()->getAttribute('category_hub_jet_category')->getFrontend()->getValue($category);
      $allCategoriesArray[$key]['new_egg_category'] = $category->getResource()->getAttribute('category_hub_new_egg_cat')->getFrontend()->getValue($category);
      $allCategoriesArray[$key]['pricefalls_category'] = $category->getResource()->getAttribute('category_hub_pricefalls')->getFrontend()->getValue($category);
      $allCategoriesArray[$key]['walmart_category'] = $category->getResource()->getAttribute('category_hub_walmart_cat')->getFrontend()->getValue($category);
      $allCategoriesArray[$key]['sears_category'] = $category->getResource()->getAttribute('category_hub_sears_category')->getFrontend()->getValue($category);
      $allCategoriesArray[$key]['amazon_category'] = $category->getResource()->getAttribute('category_hub_amazon_category')->getFrontend()->getValue($category);
    }

    //$types = array ('Integer','Text','Varchar','Decimal','Media');
    $types = array ('int'=>'catalog_product_entity_int','text'=>'catalog_product_entity_text','varchar'=>'catalog_product_entity_varchar','decimal'=>'catalog_product_entity_decimal','media'=>'catalog_product_entity_media_gallery');

    $attributesInfo = Mage::getResourceModel('eav/entity_attribute_collection')
    ->setEntityTypeFilter('4')  //4 = Default
    ->addSetInfo()
    ->getData();
    //'UniqueRetailerID','SKU','ProductTitle','LongDescription','ShortDescription','Brand','ManufacturerModel','MPN','UPC','EAN','OtherReferenceNumber','MerchantCategory','Retailer Price','AMZ MIN PRICE','AMZ MAX PRICE','ImageURL','StockQuantity','ProductURL','Weight','Length','Width','Height','neweggCat','searsCat','jetCat','googleCat','amazonCat','PriceFallsCat','Condition','priceDisc','cost','MSRP','MAPPED','ASIN','ITkeyword','labels','IsFreeShipping','color','size','gender','genderSears','isAmazon','isRakuten','isNewegg','isSears','isJet','isWalmart','Fulfilment Latency','Product Tax Code','ACA Brand'

    $needed_attribute_codes = array('status','name', 'description','short_description','brand_id','mpn','upc', 'image', 'weight', 'google_taxonomy', 'color', 'size', 'gender', 'url_key','asin','walmart_id','msrp'
      ,'amazon_price', 'amazon_allowed','walmart_price', 'walmart_allowed','sears_price', 'sears_allowed','pricefalls_price', 'pricefalls_allowed','newegg_price', 'newegg_allowed','amazon_repriced','fulfillment_latency' );
    $needed_attribute_ids = array();
    $needed_attributes = array();
    $google_attribute_id;

    $select = '';
    $leftJoin = '';
    $i = 0;

    foreach($attributesInfo as $attribute) {
      $attribute = Mage::getModel('eav/entity_attribute')->load($attribute['attribute_id']);
      if (in_array($attribute['attribute_code'], $needed_attribute_codes))
      {
        $needed_attribute_ids[] = $attribute['attribute_id'];
        $needed_attributes[$attribute['attribute_id']] = $attribute['attribute_code'];
        $select .= ", X$i.value as {$attribute['attribute_code']}";
        $leftJoin .= " LEFT JOIN `{$types[$attribute['backend_type']]}` as X$i ON P.entity_id = X$i.entity_id AND X$i.attribute_id = {$attribute['attribute_id']}";
        $i++;
      }
    }

    $needed_ids = implode(',', $needed_attribute_ids);
    $websiteID = $store->getWebsiteId();
    $qtyThreshold = Mage::getStoreConfig ('feed_options/all/all_qty_threshold');
    $query = "SET SESSION group_concat_max_len = 16000";
    $this->pdoDb->query($query);
    $query = "SELECT P.*, S.*, PR.*,MAX(C.entity_id) as category_id $select
    FROM
    (`catalog_product_entity` P,
    `cataloginventory_stock_item` S,
    `catalog_product_index_price` PR
    )
    LEFT JOIN `catalog_category_product_index` CP ON P.entity_id = CP.product_id AND CP.store_id = 1
    LEFT JOIN `catalog_category_entity` C ON C.entity_id = CP.category_id
    $leftJoin
    WHERE S.product_id = P.entity_id
    AND P.entity_id =  PR.entity_id
    AND PR.website_id = $websiteID
    AND PR.customer_group_id = 0
    AND S.qty > $qtyThreshold
    GROUP BY P.sku";
    $url = Mage::getStoreConfig ('feed_options/feeds/export_dir') .'/'. $url;
    $fh = fopen($url, "w");
    if ($fh === false) {
      return "File Open Error";
    }
    // output the column headings
    $header = array('SKU','ProductTitle','Description','Brand','MPN','UPC','Category','ImageURL','Quantity','ProductURL','Weight','Length','Width','Height',
    'Price','Amazon Price','Amazon RePriced','Walmart Price', 'PriceFalls Price', 'Jet Price', 'New Egg Price', 'Sears Price',
    'neweggCat','searsCat','jetCat','googleCat','amazonCat','PriceFallsCat','WalmartCat',
    'Condition','MSRP','ASIN','WalmartID','ITkeyword','color','size','gender',
    'Amazon Allowed','Newegg Allowed','Sears Allowed','Jet Allowed','Walmart Allowed','PriceFalls Allowed','Fulfilment Latency');

    $error = fputcsv($fh, $header);
    // make array with keys from header
    $strProdArray = array();
    foreach ($header as $val)
    {
      $strProdArray[$val]= ' ';
    }
    $cleanArr = $strProdArray;

    foreach ($this->pdoDb->query($query) as $row) {
      $strProdArray = $cleanArr;
      if ($row['status'] == 2) {
        continue;
      }
      //$strProdArray = array();
      $categoryBySku['pathStr'] = $allCategoriesArray[$row['category_id']]['pathStr'];
      //$row = array_merge($row, $this->expl_string($row, $types, $needed_attributes), $categoryBySku);

      $strProdArray['SKU'] = $row['sku'];
      $strProdArray['ProductTitle'] = $row['name'];
      if (empty($row['description'])) $strProdArray['Description'] = $row['name'];
      else $strProdArray['Description'] = $row['description'];
      $strProdArray['Brand'] = $brands[$row['brand_id']];
      $strProdArray['MPN'] = $row['mpn'];
      $strProdArray['UPC'] = $row['upc'];
      $strProdArray['Category'] = $row['pathStr'];
      $strProdArray['ImageURL'] = $media_url."catalog/product".$row['image'];
      $strProdArray['Quantity'] = $row['qty'];
      $strProdArray['ProductURL'] = $base_url.$row['url_key'].".html";
      $strProdArray['Weight'] = $row['weight'];
      $strProdArray['Length'] = $row['length'];
      $strProdArray['Width'] = $row['width'];
      $strProdArray['Height'] = $row['height'];

      $strProdArray['Price'] = $row['price'];
      $strProdArray['Amazon Price'] = $row['amazon_price'];
      $strProdArray['Amazon RePriced'] = $row['amazon_repriced'];
      $strProdArray['Walmart Price'] = $row['walmart_price'];
      $strProdArray['PriceFalls Price'] = $row['pricefalls_price'];
      $strProdArray['Jet Price'] = '';
      $strProdArray['New Egg Price'] = $row['newegg_price'];
      $strProdArray['Sears Price'] = $row['sears_price'];

      $strProdArray['neweggCat'] = $row['category_hub_new_egg_cat'];
      $strProdArray['searsCat'] = $row['category_hub_sears_category'];
      $strProdArray['jetCat'] = $row['category_hub_jet_category'];
      $strProdArray['googleCat'] = $row['google_taxonomy'];
      $strProdArray['amazonCat'] = $row['category_hub_amazon_category'];
      $strProdArray['PriceFallsCat'] = $row['category_hub_pricefalls'];
      $strProdArray['WalmartCat'] = $row['category_hub_walmart_cat'];

      $strProdArray['Condition'] = "new";
      $strProdArray['MSRP'] = $row['msrp'];
      $strProdArray['ASIN'] = $row['asin'];
      $strProdArray['WalmartID'] = $row['walmart_id'];
      $strProdArray['ITkeyword'] = '';
      $strProdArray['color'] = $colors[$row['color']];
      $strProdArray['size'] = $sizes[$row['size']];
      $strProdArray['gender'] = $genders[$row['gender']];

      $strProdArray['Amazon Allowed'] = $row['amazon_allowed'];
      $strProdArray['Newegg Allowed'] = $row['newegg_allowed'];
      $strProdArray['Sears Allowed'] = $row['sears_allowed'];
      $strProdArray['Jet Allowed'] = '';
      $strProdArray['Walmart Allowed'] = $row['walmart_allowed'];
      $strProdArray['PriceFalls Allowed'] = $row['pricefalls_allowed'];

      $strProdArray['Fulfilment Latency'] = $row['fulfillment_latency'];

      $error = fputcsv($fh,$strProdArray);
    }
    return true;
  }

}