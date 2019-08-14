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
 * Storelocator default helper
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
	 * get the url to the manage storelocator list page
	 * @access public
	 * @return string
	 * 
	 */
	public function getManagestorelocatorUrl(){
		return Mage::getUrl('storelocator/storelocator/index');
	}
}