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
 * Store list block
 *
 * @category	Magpedia
 * @package		Magpedia_Storelocator
 * 
 */
class Magpedia_Storelocator_Block_Storelocator_List extends Mage_Core_Block_Template {

    /**
     * initialize
     * @access public
     * @return void
     * 
     */
    public function __construct() {
        parent::__construct();
        $managestorelocator = Mage::getResourceModel('storelocator/storelocator_collection')
                ->addStoreFilter(Mage::app()->getStore())
                ->addFilter('status', 1)
        ;
        $managestorelocator->setOrder('storetitle', 'asc');
        $this->setManagestorelocator($managestorelocator);
    }

    /**
     * prepare the layout
     * @access protected
     * @return Magpedia_Storelocator_Block_Storelocator_List
     * 
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'storelocator.storelocator.html.pager')
                ->setCollection($this->getManagestorelocator());
        $this->setChild('pager', $pager);
        $this->getManagestorelocator()->load();        
        return $this;
    }

    /**
     * get the pager html
     * @access public
     * @return string
     * 
     */
    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    public function getJs() {
        //$genTable = '<link rel="stylesheet" type="text/css" href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN.'frontend/base/default/storelocator/css/map.css" media="all" />';
        if (Mage::getStoreConfig('storelocator/storelocator/enablejquery')) {
            ?>
            <script type="text/javascript" src="<?php echo Mage::getDesign()->getSkinUrl('storelocator/js/jquery-1.10.1.min.js'); ?>"></script>
        <?php } ?>
        <script type="text/javascript" src="<?php echo Mage::getDesign()->getSkinUrl('storelocator/js/noConflict.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Mage::getDesign()->getSkinUrl('storelocator/js/handlebars-1.0.0.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Mage::getDesign()->getSkinUrl('storelocator/js/jquery.storelocator.js'); ?>"></script>
        <?php
    }

}