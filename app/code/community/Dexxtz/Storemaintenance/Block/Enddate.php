<?php

/**
 * Copyright [2014] [Dexxtz]
 *
 * @package   Dexxtz_StoreMaintenance
 * @author    Dexxtz
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

class Dexxtz_Storemaintenance_Block_EndDate extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	/**
	 * Adds the date selection
	 * @return html
	 */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $date = new Varien_Data_Form_Element_Date;
        $format = 'MM/d/y';

        $data = array(
            'name'      => $element->getName(),
            'html_id'   => $element->getId(),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
        );
		
        $date->setData($data);
        $date->setValue($element->getValue(), $format);
        $date->setFormat($format);
		
		// The line below leaves the required field
        //$date->setClass($element->getFieldConfig()->validate->asArray());
        $date->setForm($element->getForm());

        return $date->getElementHtml();
    }
}