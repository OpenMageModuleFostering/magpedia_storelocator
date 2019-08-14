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
 * Store front contrller
 *
 * @category	Magpedia
 * @package	Magpedia_Storelocator
 * @author Magpedia
 */
class Magpedia_Storelocator_StorelocatorController extends Mage_Core_Controller_Front_Action {

    /**
     * default action
     * @access public
     * @return void
     * @author Magpedia
     */
    public function indexAction() {
        $this->loadLayout();
        if (Mage::helper('storelocator/storelocator')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb('home', array(
                    'label' => Mage::helper('storelocator')->__('Home'),
                    'link' => Mage::getUrl(),
                        )
                );
                $breadcrumbBlock->addCrumb('managestorelocator', array(
                    'label' => Mage::helper('storelocator')->__('Storelocator'),
                    'link' => '',
                        )
                );
            }
        }
        $this->renderLayout();
    }

    public function infowindowdescriptionAction() {
        echo '{{#location}}
                <div class="loc-name">{{name}}</div>
                <div>{{address}}</div>
                <div>{{country}}</div>
                <div>{{city}}, {{state}} {{postal}}</div>
                <div>{{hours1}}</div>
                <div>{{hours2}}</div>
                <div>{{hours3}}</div>
                <div>{{phone}}</div>
                {{#if storeimage}}<div class="loc-storeimage"><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'storelocator/image{{storeimage}}" width="120" height="100" >{{/if}}</div>
                <div><a href="http://{{web}}" target="_blank">{{web}}</a></div>
            {{/location}}';
    }

    public function locationlistdescriptionAction() {
        echo '
            {{#location}}
            <li data-markerid="{{markerid}}">
                    <div class="list-label">{{marker}}</div>
                    <div class="list-details">
                            <div class="list-content">
                                    <div class="loc-name">{{name}}</div>
                                    <div class="loc-addr">{{address}}</div> 
                                    <div class="loc-addr2">{{country}}</div> 
                                    <div class="loc-addr3">{{city}}, {{state}} {{postal}}</div> 
                                    <div class="loc-email">{{email}}</div>
                                    <div class="loc-phone">{{phone}}</div>
                                    <div class="loc-fax">{{fax}}</div>
                                    {{#if storeimage}}<div class="loc-storeimage"><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'storelocator/image{{storeimage}}" width="120" height="100" >{{/if}}</div>                                        
                                    <div class="loc-web"><a href="http://{{web}}" target="_blank">{{web}}</a></div>
                                    {{#if distance}}<div class="loc-dist">{{distance}} {{length}}</div>
                                    <div class="loc-directions"><a href="http://maps.google.com/maps?saddr={{origin}}&amp;daddr={{address}} {{address2}} {{city}}, {{state}} {{postal}}" target="_blank">Directions</a></div>{{/if}}                                    
                            </div>
                    </div>
            </li>
            {{/location}}';
    }

    public function locationAction() {
        $xml = '<?xml version="1.0"?>
			<markers>';
        $storeCol = Mage::getModel('storelocator/storelocator')->getCollection()
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->addFieldToFilter('status', 1);        
        foreach ($storeCol as $storeData) { 
            //echo "<pre>";print_r($storeData->getData());die;       
            $title = htmlspecialchars($storeData['storetitle'], ENT_QUOTES, 'UTF-8', false);
            $address = htmlspecialchars($storeData['address'], ENT_QUOTES, 'UTF-8', false);
            $city = htmlspecialchars($storeData['city'], ENT_QUOTES, 'UTF-8', false);
            $state = htmlspecialchars($storeData['state'], ENT_QUOTES, 'UTF-8', false);
            $email = htmlspecialchars($storeData['email'], ENT_QUOTES, 'UTF-8', false);
            $xml.='<marker name="' . $title . '" lat="' . $storeData['latitude'] . '" lng="' . $storeData['longitude'] . '" address="' . $address . '" country="' . Mage::app()->getLocale()->getCountryTranslation($storeData['country']). '" city="' . $city . '" state="' . $state . '" postal="' . $storeData['postalcode'] . '" phone="' . $storeData['phone'] . '" fax="' . $storeData['fax'].'" web="' . $storeData['web'] . '" email="'.$email.'" storeimage="'.$storeData['storeimage'].'" />';
        }
        echo $xml.='</markers>';
    }

    public function searchlocationAction() {
        $params = $this->getRequest()->getParams(); 
        $searchtxt = $params['zipcode'];
        $searchCol = Mage::getModel("storelocator/storelocator")->getCollection()
                ->addFieldToFilter(
                    array('storetitle','postalcode','state','city'),
                    array(
                        array('like'=>'%'.$searchtxt.'%'),
                        array('like'=>'%'.$searchtxt.'%'),
                        array('like'=>'%'.$searchtxt.'%'),
                        array('like'=>'%'.$searchtxt.'%')                        
                    )
                )
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->load();
        if ($searchtxt && count($searchCol) > 0) {
            $xml = '<?xml version="1.0"?>
			<markers>';
            foreach ($searchCol as $storeData) {
                $title = htmlspecialchars($storeData['storetitle'], ENT_QUOTES, 'UTF-8', false);
                $address = htmlspecialchars($storeData['address'], ENT_QUOTES, 'UTF-8', false);
                $city = htmlspecialchars($storeData['city'], ENT_QUOTES, 'UTF-8', false);
                $state = htmlspecialchars($storeData['state'], ENT_QUOTES, 'UTF-8', false);
                $email = htmlspecialchars($storeData['email'], ENT_QUOTES, 'UTF-8', false);
                $xml.='<marker name="' . $title . '" lat="' . $storeData['latitude'] . '" lng="' . $storeData['longitude'] . '" address="' . $address . '" country="' . Mage::app()->getLocale()->getCountryTranslation($storeData['country']). '" city="' . $city . '" state="' . $state . '" postal="' . $storeData['postalcode'] . '" phone="' . $storeData['phone'] . '" fax="' . $storeData['fax'].'" web="' . $storeData['web'] . '" email="'.$email.'" storeimage="'.$storeData['storeimage'].'" />';
            }
            echo $xml.='</markers>';
        } else {
            echo $xml = '<?xml version="1.0"?>
			<markers><marker name="No Record Found."/></markers>';
        }
    }

    /**
     * view store action
     * @access public
     * @return void
     * @author Magpedia
     */
    public function viewAction() {
        $storelocatorId = $this->getRequest()->getParam('id', 0);
        $storelocator = Mage::getModel('storelocator/storelocator')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($storelocatorId);
        if (!$storelocator->getId()) {
            $this->_forward('no-route');
        } elseif (!$storelocator->getStatus()) {
            $this->_forward('no-route');
        } else {
            Mage::register('current_storelocator_storelocator', $storelocator);
            $this->loadLayout();
            if ($root = $this->getLayout()->getBlock('root')) {
                $root->addBodyClass('storelocator-storelocator storelocator-storelocator' . $storelocator->getId());
            }
            if (Mage::helper('storelocator/storelocator')->getUseBreadcrumbs()) {
                if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                    $breadcrumbBlock->addCrumb('home', array(
                        'label' => Mage::helper('storelocator')->__('Home'),
                        'link' => Mage::getUrl(),
                            )
                    );
                    $breadcrumbBlock->addCrumb('managestorelocator', array(
                        'label' => Mage::helper('storelocator')->__('Manage Storelocator'),
                        'link' => Mage::helper('storelocator')->getManagestorelocatorUrl(),
                            )
                    );
                    $breadcrumbBlock->addCrumb('storelocator', array(
                        'label' => $storelocator->getStoretitle(),
                        'link' => '',
                            )
                    );
                }
            }
            $this->renderLayout();
        }
    }
    
    public function preDispatch(){
        if(!Mage::getStoreConfig('storelocator/storelocator/active')){
            $this->_redirect("");
        }
    }

}