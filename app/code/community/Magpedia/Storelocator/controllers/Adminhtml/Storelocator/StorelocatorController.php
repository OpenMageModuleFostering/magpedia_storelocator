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
 * Store admin controller
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Adminhtml_Storelocator_StorelocatorController extends Magpedia_Storelocator_Controller_Adminhtml_Storelocator{
	/**
	 * init the storelocator
	 * @access protected
	 * @return Magpedia_Storelocator_Model_Storelocator
	 */
	protected function _initStorelocator(){
		$storelocatorId  = (int) $this->getRequest()->getParam('id');
		$storelocator	= Mage::getModel('storelocator/storelocator');
		if ($storelocatorId) {
			$storelocator->load($storelocatorId);
		}
		Mage::register('current_storelocator', $storelocator);
		return $storelocator;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * 
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('storelocator')->__('Storelocator'))
			 ->_title(Mage::helper('storelocator')->__('Manage Storelocator'));
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * 
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit store - action
	 * @access public
	 * @return void
	 * 
	 */
	public function editAction() {
		$storelocatorId	= $this->getRequest()->getParam('id');
		$storelocator  	= $this->_initStorelocator();
		if ($storelocatorId && !$storelocator->getId()) {
			$this->_getSession()->addError(Mage::helper('storelocator')->__('This store no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$storelocator->setData($data);
		}
		Mage::register('storelocator_data', $storelocator);
		$this->loadLayout();
		$this->_title(Mage::helper('storelocator')->__('Storelocator'))
			 ->_title(Mage::helper('storelocator')->__('Manage Storelocator'));
		if ($storelocator->getId()){
			$this->_title($storelocator->getStoretitle());
		}
		else{
			$this->_title(Mage::helper('storelocator')->__('Add store'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new store action
	 * @access public
	 * @return void
	 * 
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save store - action
	 * @access public
	 * @return void
	 * 
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('storelocator')) {
			try {
				$storelocator = $this->_initStorelocator();
				$storelocator->addData($data);
				$storeimageName = $this->_uploadAndGetName('storeimage', Mage::helper('storelocator/storelocator_image')->getImageBaseDir(), $data);
				$storelocator->setData('storeimage', $storeimageName);
				$storelocator->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storelocator')->__('Store was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $storelocator->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				if (isset($data['storeimage']['value'])){
					$data['storeimage'] = $data['storeimage']['value'];
				}
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				if (isset($data['storeimage']['value'])){
					$data['storeimage'] = $data['storeimage']['value'];
				}
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('There was a problem saving the store.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('Unable to find store to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete store - action
	 * @access public
	 * @return void
	 * 
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$storelocator = Mage::getModel('storelocator/storelocator');
				$storelocator->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storelocator')->__('Store was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('There was an error deleteing store.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('Could not find store to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete store - action
	 * @access public
	 * @return void
	 * 
	 */
	public function massDeleteAction() {
		$storelocatorIds = $this->getRequest()->getParam('storelocator');
		if(!is_array($storelocatorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('Please select manage storelocator to delete.'));
		}
		else {
			try {
				foreach ($storelocatorIds as $storelocatorId) {
					$storelocator = Mage::getModel('storelocator/storelocator');
					$storelocator->setId($storelocatorId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storelocator')->__('Total of %d manage storelocator were successfully deleted.', count($storelocatorIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('There was an error deleteing manage storelocator.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * 
	 */
	public function massStatusAction(){
		$storelocatorIds = $this->getRequest()->getParam('storelocator');
		if(!is_array($storelocatorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('Please select manage storelocator.'));
		} 
		else {
			try {
				foreach ($storelocatorIds as $storelocatorId) {
				$storelocator = Mage::getSingleton('storelocator/storelocator')->load($storelocatorId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d manage storelocator were successfully updated.', count($storelocatorIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storelocator')->__('There was an error updating manage storelocator.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * 
	 */
	public function exportCsvAction(){
		$fileName   = 'storelocator.csv';
		$content	= $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * 
	 */
	public function exportExcelAction(){
		$fileName   = 'storelocator.xls';
		$content	= $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * 
	 */
	public function exportXmlAction(){
		$fileName   = 'storelocator.xml';
		$content	= $this->getLayout()->createBlock('storelocator/adminhtml_storelocator_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}