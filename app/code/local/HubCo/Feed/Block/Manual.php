<?php
class HubCo_Feed_Block_Manual
    extends Mage_Core_Block_Template
{
  protected function getHello() {
    return "Hello world!";
  }

  public function getCreateUrl($url, $parameters = array())
  {
    /**
     * Generate the URL for the action we want.
     */
    return Mage::helper("adminhtml")->getUrl($url,$parameters);
  }
}