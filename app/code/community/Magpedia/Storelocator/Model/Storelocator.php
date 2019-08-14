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
 * Store model
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Model_Storelocator extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'storelocator_storelocator';
	const CACHE_TAG = 'storelocator_storelocator';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'storelocator_storelocator';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'storelocator';
	/**
	 * constructor
	 * @access public
	 * @return void
	 * 
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('storelocator/storelocator');
	}
	/**
	 * before save store
	 * @access protected
	 * @return Magpedia_Storelocator_Model_Storelocator
	 * 
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
	/**
	 * get the url to the store details page
	 * @access public
	 * @return string
	 * 
	 */
	public function getStorelocatorUrl(){
		return Mage::getUrl('storelocator/storelocator/view', array('id'=>$this->getId()));
	}
	/**
	 * get the storelocator Description
	 * @access public
	 * @return string
	 * 
	 */
	public function getDescription(){
		$description = $this->getData('description');
		$helper = Mage::helper('cms');
		$processor = $helper->getBlockTemplateProcessor();
		$html = $processor->filter($description);
		return $html;
	}
	/**
	 * save storelocator relation
	 * @access public
	 * @return Magpedia_Storelocator_Model_Storelocator
	 * 
	 */
	protected function _afterSave() {
		return parent::_afterSave();
	}
}