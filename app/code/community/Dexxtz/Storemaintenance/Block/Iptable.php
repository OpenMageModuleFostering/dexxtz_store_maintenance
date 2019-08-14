<?php

class Dexxtz_Storemaintenance_Block_Iptable extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract{
	
	protected $_addAfter = false;
	
    public function __construct()
    {
        $this->addColumn('ip_address', array(
            'label' => Mage::helper('storemaintenance')->__('IP Address'),
            'style' => 'width:120px',
        ));

        $this->_addButtonLabel = Mage::helper('storemaintenance')->__('add IP');

        parent::__construct();
    }
}