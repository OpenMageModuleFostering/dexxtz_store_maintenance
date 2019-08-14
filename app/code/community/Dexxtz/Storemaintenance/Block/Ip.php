<?php

/**
 * Copyright [2014] [Dexxtz]
 *
 * @package   Dexxtz_StoreMaintenance
 * @author    Dexxtz
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

class Dexxtz_Storemaintenance_Block_Ip extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract 
{
	/**
	 * Check what is the current ip
	 * @return current ip
	 */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {        
        return $_SERVER['REMOTE_ADDR'];
    }
}