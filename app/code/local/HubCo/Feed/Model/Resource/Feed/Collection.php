<?php
class HubCo_Wps_Model_Resource_Rawdata_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();

        /**
         * Tell Magento the model and resource model to use for
         * this collection. Because both aliases are the same,
         * we can omit the second paramater if we wish.
         */
        $this->_init(
            'hubco_wps/rawdata',
            'hubco_wps/rawdata'
        );
    }
}