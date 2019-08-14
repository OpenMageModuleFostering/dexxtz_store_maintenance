<?php

/**
 * Copyright [2014] [Dexxtz]
 *
 * @package   Dexxtz_StoreMaintenance
 * @author    Dexxtz
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

class Dexxtz_Storemaintenance_Block_Ipgrid extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
	
	protected $_addAfter = false;
	
	/*
	 * Builds the button that adds the table filling ips	 * 
	 */
    public function __construct()
    {
    	// Build rows and columns
        $this->addColumn('ip_address', array(
            'label' => Mage::helper('storemaintenance')->__('IP Address'),
            'style' => 'width:120px',
        ));

        $this->_addButtonLabel = Mage::helper('storemaintenance')->__('add IP');

        parent::__construct();
    }
}