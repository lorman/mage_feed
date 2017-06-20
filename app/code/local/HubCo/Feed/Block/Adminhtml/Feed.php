<?php
class HubCo_Wps_Block_Adminhtml_Rawdata
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        /**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed in this grid container.
         * In our example, this corresponds to BrandDirectory/Block/Adminhtml.
         */
        $this->_blockGroup = 'hubco_wps_adminhtml';

        /**
         * $_controller is a slightly confusing name for this property.
         * This value, in fact, refers to the folder containing our
         * Grid.php and Edit.php - in our example,
         * BrandDirectory/Block/Adminhtml/Brand. So, we'll use 'brand'.
         */
        $this->_controller = 'rawdata';

        /**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('hubco_wps')
            ->__('Raw Data');
        parent::_construct();
        $this->_removeButton('add');
    }

    public function getCreateUrl()
    {
        /**
         * When the "Add" button is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in BrandDirectory module.
         */
      return null;
        return $this->getUrl(
            'hubco_wps_admin/rawdata/edit'
        );
    }
}