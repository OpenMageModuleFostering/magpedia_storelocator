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
 * Store admin grid block
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Adminhtml_Storelocator_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * 
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('storelocatorGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Magpedia_Storelocator_Block_Adminhtml_Storelocator_Grid
	 * 
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('storelocator/storelocator')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Magpedia_Storelocator_Block_Adminhtml_Storelocator_Grid
	 * 
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('storelocator')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
		$this->addColumn('storetitle', array(
			'header'=> Mage::helper('storelocator')->__('Store Title'),
			'index' => 'storetitle',
			'type'	 	=> 'text',

		));
		$this->addColumn('country', array(
			'header'=> Mage::helper('storelocator')->__('Country'),
			'index' => 'country',
			'type'		=> 'country',

		));
		$this->addColumn('city', array(
			'header'=> Mage::helper('storelocator')->__('City'),
			'index' => 'city',
			'type'	 	=> 'text',

		));
		
                $this->addColumn('postalcode', array(
			'header'=> Mage::helper('storelocator')->__('Postal Code'),
			'index' => 'postalcode',
			'type'	 	=> 'text',
		));
                
                $this->addColumn('storeimage', array(
			'header'=> Mage::helper('storelocator')->__('Store Image'),
			'index' => 'storeimage',
                        'renderer' => 'Magpedia_Storelocator_Block_Adminhtml_Storelocator_Image',
		));
                
		$this->addColumn('status', array(
			'header'	=> Mage::helper('storelocator')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('storelocator')->__('Enabled'),
				'0' => Mage::helper('storelocator')->__('Disabled'),
			)
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('storelocator')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}
		$this->addColumn('action',
                    array(
                            'header'=>  Mage::helper('storelocator')->__('Action'),
                            'width' => '100',
                            'type'  => 'action',
                            'getter'=> 'getId',
                            'actions'   => array(
                                    array(
                                            'caption'   => Mage::helper('storelocator')->__('Edit'),
                                            'url'   => array('base'=> '*/*/edit'),
                                            'field' => 'id'
                                    )
                            ),
                            'filter'=> false,
                            'is_system'	=> true,
                            'sortable'  => false,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('storelocator')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('storelocator')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('storelocator')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Magpedia_Storelocator_Block_Adminhtml_Storelocator_Grid
	 * 
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('storelocator');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('storelocator')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('storelocator')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('storelocator')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('storelocator')->__('Status'),
						'values' => array(
								'1' => Mage::helper('storelocator')->__('Enabled'),
								'0' => Mage::helper('storelocator')->__('Disabled'),
						)
				)
			)
		));
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Magpedia_Storelocator_Model_Storelocator
	 * @return string
	 * 
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * 
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Magpedia_Storelocator_Block_Adminhtml_Storelocator_Grid
	 * 
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Magpedia_Storelocator_Model_Resource_Storelocator_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Magpedia_Storelocator_Block_Adminhtml_Storelocator_Grid
	 * 
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
}