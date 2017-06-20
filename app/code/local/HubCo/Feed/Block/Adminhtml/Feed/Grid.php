<?php
class HubCo_Wps_Block_Adminhtml_Rawdata_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        /**
         * Tell Magento which collection to use to display in the grid.
         */
        $collection = Mage::getResourceModel(
            'hubco_wps/rawdata_collection'
        );
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function getRowUrl($row)
    {
        /**
         * When a grid row is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in BrandDirectory module.
         *
        return $this->getUrl(
            'hubco_wps_admin/rawftpprice/edit',
            array(
                'id' => $row->getId()
            )
        );
        */
      return null;
    }

    protected function _prepareColumns()
    {
        /**
         * Here, we'll define which columns to display in the grid.
         */
        $this->addColumn('itemNum', array(
            'header' => $this->_getHelper()->__('itemNum'),
            'type' => 'text',
            'index' => 'itemNum',
        ));

        $this->addColumn('brand', array(
            'header' => $this->_getHelper()->__('brand'),
            'type' => 'text',
            'index' => 'brand',
        ));

        $this->addColumn('mpn', array(
            'header' => $this->_getHelper()->__('mpn'),
            'type' => 'text',
            'index' => 'mpn',
        ));

        $this->addColumn('title', array(
            'header' => $this->_getHelper()->__('title'),
            'type' => 'text',
            'index' => 'title',
        ));

        $this->addColumn('qtyAll', array(
            'header' => $this->_getHelper()->__('qtyAll'),
            'type' => 'text',
            'index' => 'qtyAll',
        ));

        $this->addColumn('status', array(
            'header' => $this->_getHelper()->__('status'),
            'type' => 'text',
            'index' => 'status',
        ));

        $this->addColumn('msrp', array(
            'header' => $this->_getHelper()->__('msrp'),
            'type' => 'currency',
            'index' => 'msrp',
        ));
        $this->addColumn('cost', array(
            'header' => $this->_getHelper()->__('cost'),
            'type' => 'currency',
            'index' => 'cost',
        ));

        $this->addColumn('upc', array(
            'header' => $this->_getHelper()->__('upc'),
            'type' => 'text',
            'index' => 'upc',
        ));

        $this->addColumn('images', array(
            'header' => $this->_getHelper()->__('images'),
            'type' => 'text',
            'index' => 'images',
        ));

        $this->addColumn('description', array(
            'header' => $this->_getHelper()->__('description'),
            'type' => 'text',
            'index' => 'description',
        ));
        $this->addColumn('catalogs', array(
            'header' => $this->_getHelper()->__('catalogs'),
            'type' => 'text',
            'index' => 'catalogs',
        ));
        $this->addColumn('attributes', array(
            'header' => $this->_getHelper()->__('attributes'),
            'type' => 'text',
            'index' => 'attributes',
        ));
        $this->addColumn('fitment', array(
            'header' => $this->_getHelper()->__('fitment'),
            'type' => 'text',
            'index' => 'fitment',
        ));
        $this->addColumn('qtyChange', array(
            'header' => $this->_getHelper()->__('qtyChange'),
            'type' => 'number',
            'index' => 'qtyChange',
        ));
        $this->addColumn('descChange', array(
            'header' => $this->_getHelper()->__('descChange'),
            'type' => 'number',
            'index' => 'descChange',
        ));
        $this->addColumn('imgChange', array(
            'header' => $this->_getHelper()->__('imgChange'),
            'type' => 'number',
            'index' => 'imgChange',
        ));
        $this->addColumn('attrChange', array(
            'header' => $this->_getHelper()->__('attrChange'),
            'type' => 'number',
            'index' => 'attrChange',
        ));
        $this->addColumn('fitmentChange', array(
            'header' => $this->_getHelper()->__('fitmentChange'),
            'type' => 'number',
            'index' => 'fitmentChange',
        ));

        return parent::_prepareColumns();
    }

    protected function _getHelper()
    {
        return Mage::helper('hubco_wps');
    }
}