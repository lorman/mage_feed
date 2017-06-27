<?php
class HubCo_Feed_Adminhtml_ManualController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page, we will see a grid of all
     * brands currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */
    public function indexAction()
    {
      //cho $this->getFullActionName(); //layout handle goes in the layout.xml as the main wrapper
      //var_dump(Mage::getConfig()->getBlockClassName('hubco_wps/manual')); Gets the class file that is the type in the layout
      //var_dump(mageFindClassFile('HubCo_Wps_Block_Manual')); // tests that the class file can be found
        $this->loadLayout();
        $this->renderLayout();
    }

    public function exportEdgeGoogleAction() {

      $success = Mage::getSingleton('hubco_feed/feed')->exportEdgeGoogle();
      if ($success)
        $this->_getSession()->addSuccess(
            $this->__('Exported')
        );
      else
        $this->_getSession()->addError(  $success
        );
      return $this->_redirect(
          'hubco_feed_admin/manual/index'
      );
    }

    public function testEdgeGoogleAction() {

      $success = Mage::getSingleton('hubco_feed/feed')->exportEdgeGoogle(true);
      if ($success)
        $this->_getSession()->addSuccess(
            $this->__('Exported')
        );
      else
        $this->_getSession()->addError(  $success
        );
      return $this->_redirect(
          'hubco_feed_admin/manual/index'
      );
    }

    public function exportAllAction() {

      $success = Mage::getSingleton('hubco_feed/feedAll')->export();
      if ($success)
        $this->_getSession()->addSuccess(
            $this->__('Exported')
        );
      else
        $this->_getSession()->addError(  $success
        );
      return $this->_redirect(
          'hubco_feed_admin/manual/index'
      );


    }

    /**
     * Thanks to Ben for pointing out this method was missing. Without
     * this method the ACL rules configured in adminhtml.xml are ignored.
     */
    protected function _isAllowed()
    {
        /**
         * we include this switch to demonstrate that you can add action
         * level restrictions in your ACL rules. The isAllowed() method will
         * use the ACL rule we have configured in our adminhtml.xml file:
         * - acl
         * - - resources
         * - - - admin
         * - - - - children
         * - - - - - smashingmagazine_branddirectory
         * - - - - - - children
         * - - - - - - - brand
         *
         * eg. you could add more rules inside brand for edit and delete.
         */
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
                // intentionally no break
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('hubco_feed/manual');
                break;
        }

        return $isAllowed;
    }
}