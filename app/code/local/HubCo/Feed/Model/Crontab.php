<?php
class HubCo_Wps_Model_Crontab
{
/**
 * USED to manage all cronjobs and to run the function from the manual controller
 */

  public function ftpDaily() {
    $helper = Mage::helper('hubco_wps');
    return $helper->DownloadFTP();
  }
}