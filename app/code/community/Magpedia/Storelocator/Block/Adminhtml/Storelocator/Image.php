<?php
class Magpedia_Storelocator_Block_Adminhtml_Storelocator_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $getData = $row->getData();
        if($getData['storeimage']){ ?>
            <img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'storelocator/image'.$getData['storeimage'];?>" width="100" height="100" >
        <?php }
    }
}
?>