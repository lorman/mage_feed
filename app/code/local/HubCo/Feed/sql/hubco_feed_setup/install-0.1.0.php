<?php
$this->startSetup ();

// /**
//  * Note: there are many ways in Magento to achieve the same result below
//  * of creating a database table.
//  * For this tutorial we have gone with the
//  * Varien_Db_Ddl_Table method but feel free to explore what Magento do in
//  * CE 1.8.0.0 and ealier versions if you are interested.
//  */
// $table = new Varien_Db_Ddl_Table ();

// /**
//  * This is an alias to the real name of our database table, which is
//  * configured in config.xml.
//  * By using an alias we can reference the same
//  * table throughout our code if we wish and if the table name ever had to
//  * change we could simply update a single location, config.xml
//  * - smashingmagazine_branddirectory is the model alias
//  * - brand is the table reference
//  */
// $table->setName ( $this->getTable ( 'hubco_wps/rawqty' ) );
// /**
//  * Add the columns we need for now.
//  * If you need more in the future you can
//  * always create a new setup script as an upgrade, we will introduce that
//  * later on in the tutorial.
//  */
// $table->addColumn ( 'ITEM_NUM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'DESC', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'QTY_BOI', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'QTY_CAL', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'QTY_MEM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'QTY_PEN', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'QTY_IND', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'QTY_TEX', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'STATUS', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );

// $table->addColumn ( 'VND_ITEM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );

// $table->addColumn ( 'VND_NAME', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );

// $table->addColumn ( 'UPC', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'CLS_OUT', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'MAP', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'KIT', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );

// /**
//  * A couple of important lines that are often missed.
//  */
// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/rawqty' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }
// /**
//  * set up the second table
//  */
// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/rawftpprice' ) );

// $table->addColumn ( 'WCITEM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'WCDSC', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WCUM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WFPR1', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WFQB2', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WFPR2', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WFQB3', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WFPR3', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WFPRS', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WMOTR', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WSNOW', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WWATR', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WATV', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WVENDOR', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WVENDORNM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WUPC', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WCLSOUT', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'WMAP', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/rawftpprice' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }
// /**
//  * set up the second table
//  */
// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/customprice' ) );

// $table->addColumn ( 'Item_Number', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'Description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'List_Price', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Suggested_Dealer', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Actual_Dealer', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'UoM', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Weight', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_Boise', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_Fresno', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_Memphis', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_ETown', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_Ashley', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_Texas', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_All', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Qty_PO', Varien_Db_Ddl_Table::TYPE_VARCHAR, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Closeout', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Map_Policy', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Kit_Item', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Vendor_Item', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Vendor_Name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'UPC', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Apparel', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Street', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Vtwin', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Offroad', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Snowmobile', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'ATV', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Watercraft', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Bicycle', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Fly', Varien_Db_Ddl_Table::TYPE_VARCHAR, 4, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'Date_Time_Stamp', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array (
//     'nullable' => false
// ) );
// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/customprice' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }

// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/apidata' ) );

// $table->addColumn ( 'id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'catalog_description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'vendor_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'vendor_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'video', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'country_of_origin_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'last_update_date', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'has_fitment', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'has_map_policy', Varien_Db_Ddl_Table::TYPE_VARCHAR, 63, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'catalogs', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'attributes', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'fitment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'self_href', Varien_Db_Ddl_Table::TYPE_VARCHAR, 127, array (
//     'nullable' => false
// ) );
// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/apidata' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }

// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/rawdata' ) );

// $table->addColumn ( 'itemNum', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'brand', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'mpn', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyBoise', Varien_Db_Ddl_Table::TYPE_INTEGER, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyFresno', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyMemphis', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyETown', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyAshley', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyTexas', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyAll', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'map', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'closeout', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'msrp', Varien_Db_Ddl_Table::TYPE_DECIMAL, '7,2', array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'cost', Varien_Db_Ddl_Table::TYPE_DECIMAL, '7,2', array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'uom', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'weight', Varien_Db_Ddl_Table::TYPE_DECIMAL, '7,2', array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'upc', Varien_Db_Ddl_Table::TYPE_VARCHAR, 15, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'images', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'country', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'catalogs', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'attributes', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'fitment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'descChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'imgChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'attrChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'fitmentChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );

// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );


// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/rawdata' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }

// // add index
// $tableName = $this->getTable('hubco_wps/rawdata');
// // Check if the table already exists
// if ($this->getConnection ()->isTableExists ( $tableName )) {
//   $table = $this->getConnection ();

//   $table->addIndex ( $this->getTable ( 'hubco_wps/rawdata' ), $this->getIdxName ( 'hubco_wps/rawdata', array (
//       'qtyChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'qtyChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/rawdata' ), $this->getIdxName ( 'hubco_wps/rawdata', array (
//       'descChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'descChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/rawdata' ), $this->getIdxName ( 'hubco_wps/rawdata', array (
//       'imgChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'imgChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/rawdata' ), $this->getIdxName ( 'hubco_wps/rawdata', array (
//       'attrChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'attrChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/rawdata' ), $this->getIdxName ( 'hubco_wps/rawdata', array (
//       'fitmentChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'fitmentChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );
// }

// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/cleandata' ) );

// $table->addColumn ( 'itemNum', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'brand', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'mpn', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'locationQty', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyAll', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'map', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'msrp', Varien_Db_Ddl_Table::TYPE_DECIMAL, '7,2', array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'cost', Varien_Db_Ddl_Table::TYPE_DECIMAL, '7,2', array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'uom', Varien_Db_Ddl_Table::TYPE_VARCHAR, 10, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'weight', Varien_Db_Ddl_Table::TYPE_DECIMAL, '7,2', array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'upc', Varien_Db_Ddl_Table::TYPE_VARCHAR, 15, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'images', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'catalogs', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'fitment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'attributes', Varien_Db_Ddl_Table::TYPE_TEXT, null, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'qtyChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'brandChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'titleChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'descChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'imgChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'attributeChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'fitmentChange', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'lastCleaned', Varien_Db_Ddl_Table::TYPE_DATETIME, 20, array (
//     'nullable' => true
// ) );

// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/cleandata' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }

// // add index
// $tableName = $this->getTable('hubco_wps/cleandata');
// // Check if the table already exists
// if ($this->getConnection ()->isTableExists ( $tableName )) {
//   $table = $this->getConnection ();

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'qtyChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'qtyChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'brandChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'brandChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'titleChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'titleChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'descChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'descChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'imgChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'imgChange',
//       'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'attributeChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'attributeChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'fitmentChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'fitmentChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'brand'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'brand'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'itemNum',
//       'brandChange','titleChange','descChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'brandChange','titleChange','descChange'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'brand',
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'brand',
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'status',
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'status',
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleandata' ), $this->getIdxName ( 'hubco_wps/cleandata', array (
//       'map',
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'map',
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );
// }

// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/cleanattributes' ) );

// $table->addColumn ( 'itemNum', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'value', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'nameClean', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'valueClean', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'toIgnore', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'toDescription', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'changed', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'lastCleaned', Varien_Db_Ddl_Table::TYPE_DATETIME, 20, array (
//     'nullable' => true
// ) );

// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/cleanattributes' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }

// // add index
// $tableName = $this->getTable('hubco_wps/cleanattributes');
// // Check if the table already exists
// if ($this->getConnection ()->isTableExists ( $tableName )) {
//   $table = $this->getConnection ();

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanattributes' ), $this->getIdxName ( 'hubco_wps/cleanattributes', array (
//       'itemNum',
//       'value', 'valueClean'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'value', 'valueClean'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanattributes' ), $this->getIdxName ( 'hubco_wps/cleanattributes', array (
//       'itemNum',
//       'name', 'value', 'changed', 'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'name', 'value', 'changed', 'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );
// }

// $table = new Varien_Db_Ddl_Table ();
// $table->setName ( $this->getTable ( 'hubco_wps/cleanfitments' ) );

// $table->addColumn ( 'itemNum', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'make', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'model', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'year', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'auto_increment' => false,
//     'nullable' => false,
//     'primary' => true
// ) );
// $table->addColumn ( 'makeClean', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'modelClean', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'changed', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array (
//     'nullable' => false
// ) );
// $table->addColumn ( 'lastCleaned', Varien_Db_Ddl_Table::TYPE_DATETIME, 20, array (
//     'nullable' => true
// ) );

// $table->setOption ( 'type', 'InnoDB' );
// $table->setOption ( 'charset', 'utf8' );

// if (!$this->getConnection ()->isTableExists ( $this->getTable ( 'hubco_wps/cleanfitments' )  )) {
//   /**
//    * Create the table!
//    */
//   $this->getConnection()->createTable($table);
// }

// // add index
// $tableName = $this->getTable('hubco_wps/cleanfitments');
// // Check if the table already exists
// if ($this->getConnection ()->isTableExists ( $tableName )) {
//   $table = $this->getConnection ();

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanfitments' ), $this->getIdxName ( 'hubco_wps/cleanfitments', array (
//       'itemNum',
//       'make', 'makeClean', 'changed'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'itemNum',
//       'make', 'makeClean', 'changed'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanfitments' ), $this->getIdxName ( 'hubco_wps/cleanfitments', array (
//       'changed', 'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'changed', 'lastCleaned'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanfitments' ), $this->getIdxName ( 'hubco_wps/cleanfitments', array (
//       'make','changed'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'make','changed'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanfitments' ), $this->getIdxName ( 'hubco_wps/cleanfitments', array (
//       'model','changed'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'model','changed'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanfitments' ), $this->getIdxName ( 'hubco_wps/cleanfitments', array (
//       'modelClean'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'modelClean'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );

//   $table->addIndex ( $this->getTable ( 'hubco_wps/cleanfitments' ), $this->getIdxName ( 'hubco_wps/cleanfitments', array (
//       'makeClean'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX ), array (
//       'makeClean'
//   ), Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX );
// }

$this->endSetup ();
