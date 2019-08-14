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
 * Store admin edit tabs
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Adminhtml_Storelocator_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * 
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('storelocator_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('storelocator')->__('Store'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Magpedia_Storelocator_Block_Adminhtml_Storelocator_Edit_Tabs
	 * 
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_storelocator', array(
			'label'		=> Mage::helper('storelocator')->__('Store'),
			'title'		=> Mage::helper('storelocator')->__('Store'),
			'content' 	=> $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_edit_tab_form')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_storelocator', array(
				'label'		=> Mage::helper('storelocator')->__('Store views'),
				'title'		=> Mage::helper('storelocator')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_edit_tab_stores')->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}