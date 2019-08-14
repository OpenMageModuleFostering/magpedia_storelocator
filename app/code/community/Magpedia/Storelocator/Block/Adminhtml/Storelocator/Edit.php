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
 * Store admin edit block
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Adminhtml_Storelocator_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * 
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'storelocator';
		$this->_controller = 'adminhtml_storelocator';
		$this->_updateButton('save', 'label', Mage::helper('storelocator')->__('Save Store'));
		$this->_updateButton('delete', 'label', Mage::helper('storelocator')->__('Delete Store'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('storelocator')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * 
	 */
	public function getHeaderText(){
		if( Mage::registry('storelocator_data') && Mage::registry('storelocator_data')->getId() ) {
			return Mage::helper('storelocator')->__("Edit Store '%s'", $this->htmlEscape(Mage::registry('storelocator_data')->getStoretitle()));
		} 
		else {
			return Mage::helper('storelocator')->__('Add Store');
		}
	}
}