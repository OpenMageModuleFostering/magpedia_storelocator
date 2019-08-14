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
 * Store edit form tab
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Adminhtml_Storelocator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Storelocator_Storelocator_Block_Adminhtml_Storelocator_Edit_Tab_Form
	 * 
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('storelocator_');
		$form->setFieldNameSuffix('storelocator');
		$this->setForm($form);
		$fieldset = $form->addFieldset('storelocator_form', array('legend'=>Mage::helper('storelocator')->__('Store')));
		$fieldset->addType('image', Mage::getConfig()->getBlockClassName('storelocator/adminhtml_storelocator_helper_image'));
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

		$fieldset->addField('storetitle', 'text', array(
			'label' => Mage::helper('storelocator')->__('Store Title'),
			'name'  => 'storetitle',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('storelink', 'text', array(
			'label' => Mage::helper('storelocator')->__('Store Link'),
			'name'  => 'storelink',

		));

		$fieldset->addField('country', 'select', array(
			'label' => Mage::helper('storelocator')->__('Country'),
			'name'  => 'country',
			'required'  => true,
			'class' => 'required-entry',

			'values'=> Mage::getResourceModel('directory/country_collection')->toOptionArray(),
		));

		$fieldset->addField('state', 'text', array(
			'label' => Mage::helper('storelocator')->__('State'),
			'name'  => 'state',

		));

		$fieldset->addField('city', 'text', array(
			'label' => Mage::helper('storelocator')->__('City'),
			'name'  => 'city',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('postalcode', 'text', array(
			'label' => Mage::helper('storelocator')->__('Postal Code'),
			'name'  => 'postalcode',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('address', 'text', array(
			'label' => Mage::helper('storelocator')->__('Address'),
			'name'  => 'address',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('latitude', 'text', array(
			'label' => Mage::helper('storelocator')->__('Latitude'),
			'name'  => 'latitude',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('longitude', 'text', array(
			'label' => Mage::helper('storelocator')->__('Longitude'),
			'name'  => 'longitude',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('email', 'text', array(
			'label' => Mage::helper('storelocator')->__('Store Email'),
			'name'  => 'email',

		));

		$fieldset->addField('phone', 'text', array(
			'label' => Mage::helper('storelocator')->__('Phone'),
			'name'  => 'phone',

		));

		$fieldset->addField('fax', 'text', array(
			'label' => Mage::helper('storelocator')->__('Fax'),
			'name'  => 'fax',

		));

		$fieldset->addField('description', 'editor', array(
			'label' => Mage::helper('storelocator')->__('Description'),
			'name'  => 'description',
			'config'	=> $wysiwygConfig,

		));

		$fieldset->addField('storeimage', 'image', array(
			'label' => Mage::helper('storelocator')->__('Store Image'),
			'name'  => 'storeimage',

		));

		$fieldset->addField('sortorder', 'text', array(
			'label' => Mage::helper('storelocator')->__('Sort Order'),
			'name'  => 'sortorder',

		));

		$fieldset->addField('storetime', 'text', array(
			'label' => Mage::helper('storelocator')->__('Store Time'),
			'name'  => 'storetime',

		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('storelocator')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('storelocator')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('storelocator')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_storelocator')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getStorelocatorData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getStorelocatorData());
			Mage::getSingleton('adminhtml/session')->setStorelocatorData(null);
		}
		elseif (Mage::registry('current_storelocator')){
			$form->setValues(Mage::registry('current_storelocator')->getData());
		}
		return parent::_prepareForm();
	}
}