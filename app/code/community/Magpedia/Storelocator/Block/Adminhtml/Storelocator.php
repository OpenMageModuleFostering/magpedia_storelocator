<?php
/**
 * Magpedia_Storelocator extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Magpedia
 * @package	Magpedia_Storelocator
 * @copyright  	Copyright (c) 2014
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Store admin block
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Adminhtml_Storelocator extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * 
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_storelocator';
		$this->_blockGroup 		= 'storelocator';
		$this->_headerText 		= Mage::helper('storelocator')->__('Store');
		$this->_addButtonLabel 	= Mage::helper('storelocator')->__('Add Store');
		parent::__construct();
	}
}