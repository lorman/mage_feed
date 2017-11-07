<?php
class HubCo_Feed_Model_Fixes
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

  public function fixStateAbbreviations () {
    $states = Mage::getModel('directory/country')->load('US')->getRegions();//state names
echo "<pre>";
    foreach ($states as $state)
    {
      $abbreviation = $state->getCode();
      $name = $state->getName();
      $query = "UPDATE sales_flat_order_address SET region = '$name' WHERE region = '$abbreviation'";
      $this->writeCon->query($query);
    }
  }
}