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
 * Storelocator module install script
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
$this->startSetup();
$table = $this->getConnection()
	->newTable($this->getTable('storelocator/storelocator'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addColumn('storetitle', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Store Title')

	->addColumn('storelink', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Store Link')

	->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, 2, array(
		'nullable'  => false,
		), 'Country')

	->addColumn('state', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'State')

	->addColumn('city', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'City')

	->addColumn('postalcode', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Postal Code')

	->addColumn('address', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Address')

	->addColumn('latitude', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Latitude')

	->addColumn('longitude', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Longitude')

	->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Store Email')

	->addColumn('phone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Phone')

	->addColumn('fax', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Fax')

	->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Description')

	->addColumn('storeimage', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Store Image')

	->addColumn('sortorder', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Sort Order')

	->addColumn('storetime', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Store Time')

	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'Status')

	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Store Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Store Modification Time')
	->setComment('Store Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
	->newTable($this->getTable('storelocator/storelocator_store'))
	->addColumn('storelocator_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addIndex($this->getIdxName('storelocator/storelocator_store', array('store_id')), array('store_id'))
	->addForeignKey($this->getFkName('storelocator/storelocator_store', 'storelocator_id', 'storelocator/storelocator', 'entity_id'), 'storelocator_id', $this->getTable('storelocator/storelocator'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('storelocator/storelocator_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Manage Storelocator To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();