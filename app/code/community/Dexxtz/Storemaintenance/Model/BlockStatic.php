<?php

/**
 * Copyright [2014] [Dexxtz]
 *
 * @package   Dexxtz_StoreMaintenance
 * @author    Dexxtz
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
 
class Dexxtz_Storemaintenance_Model_BlockStatic
{
    protected $_options;
	
	/**
	 * Mounts the static blocks in combobox
	 * @return static blocks available
	 */
    public function toOptionArray()
    {
        if(!$this -> _options){
            $this    -> _options = array(
                array(
                    'value' => 0,
                    'label' => Mage::helper('catalog')->__('Please select one static block ...'),
                )
            );

            $options = Mage::getResourceModel('cms/block_collection') -> load() -> toOptionArray();
            $this -> _options = array_merge($this -> _options, $options);
        }
		
        return $this->_options;
    }
}