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
 * Store view block
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Storelocator_View extends Mage_Core_Block_Template{
	/**
	 * get the current store
	 * @access public
	 * @return mixed (Magpedia_Storelocator_Model_Storelocator|null)
	 * 
	 */
	public function getCurrentStorelocator(){
		return Mage::registry('current_storelocator_storelocator');
	}
} 