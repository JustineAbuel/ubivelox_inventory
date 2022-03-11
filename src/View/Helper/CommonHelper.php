<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

use CodeItNow\BarcodeBundle\Utils\QrCode;
use Controller\Component\CommonComponent;
/**
 * Common helper
 */
class CommonHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = []; 
    
    public function generateQrInView($param){
        $qrCode = new QrCode();
        $qrCode
            ->setText($param)
            ->setSize(100)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            // ->setLabel($item->item_name)
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        
        echo'<img src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" />'; 
    }

    public function menus($param){
        $qrCode = new QrCode();
        $qrCode
            ->setText($param)
            ->setSize(100)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            // ->setLabel($item->item_name)
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        
        echo'<img src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" />'; 
    }
}
