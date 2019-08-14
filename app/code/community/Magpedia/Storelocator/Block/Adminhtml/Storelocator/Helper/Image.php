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
 * Store image field renderer helper
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Adminhtml_Storelocator_Helper_Image extends Varien_Data_Form_Element_Image{
	/**
	 * get the url of the image
	 * @access protected
	 * @return string
	 * 
	 */
	protected function _getUrl(){
		$url = false;
		if ($this->getValue()) {
			$url = Mage::helper('storelocator/storelocator_image')->getImageBaseUrl().$this->getValue();
		}
		return $url;
	}
}
 