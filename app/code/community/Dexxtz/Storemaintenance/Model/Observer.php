<?php

/**
 * Copyright [2014] [Dexxtz]
 *
 * @package   Dexxtz_StoreMaintenance
 * @author    Dexxtz
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
 
class Dexxtz_Storemaintenance_Model_Observer
{
    public function initControllerStoremaintenance($request) 
    {
    	// Sets the timezone selected by shopkeeper
    	date_default_timezone_set(Mage::getStoreConfig('general/locale/timezone'));        	
		
    	$url = Mage::helper('core/url')->getCurrentUrl();
		$adminArea = 0;
		
		// checks whether the current page belongs to the administrator
		if (strpos($url, '/admin') || strpos($url, '/adminhtml') || strpos($url, '/downloader')) {
			$adminArea = 1;
		}
		
		// Performs if not is administrative area
        if ($adminArea == 0) {
        	
            $storeId = Mage::app()->getStore()->getStoreId();
            $isEnabled = Mage::getStoreConfig('storemaintenance/dexxtz/activate',$storeId);
			
			// verifies if the module is enabled
            if ($isEnabled == 1) {
                $allowedIPs = Mage::getStoreConfig('storemaintenance/dexxtz/allowedIPs',$storeId);
                $allowedIPs = preg_replace('/ /', '', $allowedIPs);
                $array = unserialize(Mage::getStoreConfig('storemaintenance/dexxtz/ip_grid'));
				
				// assembles an array with informed ips
				foreach ($array as $key => $value) {
					$IPs[] = $value['ip_address'];
				}
				
                $currentIP = $_SERVER['REMOTE_ADDR'];
                $allowForAdmin = Mage::getStoreConfig('storemaintenance/dexxtz/activate_admin',$storeId);
                $adminIp = null;
				
				// verifies if the administrator can view the frontend
                if ($allowForAdmin == 1) {
                    Mage::getSingleton('core/session', array('name' => 'adminhtml'));
                    $adminSession = Mage::getSingleton('admin/session');
					
					// checks if the admin is logged in and capture your ip
                    if ($adminSession->isLoggedIn()) {
                        $adminIp = $adminSession['_session_validator_data']['remote_addr'];
                    }
                }		
								
				$endDate = Mage::getStoreConfig('storemaintenance/dexxtz/end_date');
				$checkDate = 0;
				
				// Checks if a date was set for the end of maintenance
				if ($endDate) {					
					$timestamp_endDate = strtotime($endDate);
					$currentDate = date('m/d/Y');
					$timestamp_currentDate = strtotime($currentDate);	
					
					// checks whether the current date is greater than the date specified in the module					
					if ($timestamp_currentDate > $timestamp_endDate) {
						$checkDate = 1;
					}
				}
				
				// checks if the ip current is different from ip of admin logged
                if ($currentIP != $adminIp) {
                	
                	// checks if the ip can access or if the date will access
                    if (!in_array($currentIP, $IPs) && $checkDate == 0) {
                    	
                    	// stores the html of the page maintenance
                        $html = Mage::getSingleton('core/layout')->createBlock('core/template')->setTemplate('dexxtz/store_maintenance.phtml')->toHtml();
						$activate_log = Mage::getStoreConfig('storemaintenance/dexxtz/activate_log');
						
						// create log
						if ($activate_log == 1) {
							$archive_log = Mage::getStoreConfig('storemaintenance/dexxtz/archive_log');
							$file = ($archive_log == '') ? 'MaintenanceLog.txt' : $archive_log;
							$date = date('m/d/Y h:i A');
							$urlBase = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
							$urlCurrent = Mage::helper('core/url')->getCurrentUrl();
							$accessedArea =  str_replace('index.php/','',str_replace($urlBase,'',$urlCurrent));
							$accessedArea = ($accessedArea == '') ? 'home' : $accessedArea;								
							$log = 'array("Date" => "' . $date . '", "IP" => "' . $currentIP . '", "Accessed Area" => "' . $accessedArea . '")' . PHP_EOL;
							
							// adds a new line to the log file
							file_put_contents($file, $log, FILE_APPEND);
						}

						// mounts the display of the page of maintenance on page current
                        if ('' !== $html) {
                            Mage::getSingleton('core/session', array('name' => 'front'));
                            $response = $request->getEvent()->getFront()->getResponse();
                            $response->setHeader('HTTP/1.1', '503 Service Temporarily Unavailable');
                            $response->setHeader('Status', '503 Service Temporarily Unavailable');
                            $response->setHeader('Retry-After', '5000');
                            $response->setBody($html);
                            $response->sendHeaders();
                            $response->outputBody();
                        }
						
						// break page display
                        exit();
                    }
           		}
            }
    	}
    }        
}
