<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use CodeItNow\BarcodeBundle\Utils\QrCode;

/**
 * Common component
 */
class CommonComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $components = [
        'Authentication.Authentication',
        'RequestHandler'
    ];
    public function initialize(array $_defaultConfig): void
    { 
          
    } 
    public function generateQr($param){
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
        return $qrCode;
    }
    function getUserIP()
    {
        $client = isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : '';
        $forward = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : '';
        $remote = $_SERVER["REMOTE_ADDR"];
    
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
    
        return $ip;
    } 
    public function dblogger($param){
 
        $loggedinuser = $this->Authentication->getIdentity()->getOriginalData();

        $this->log($param['message'], 'info', [
            'channel' => 1,
            'ip_address' =>  $this->getUserIP(),
            'username' => $loggedinuser->username,
            'role' => $loggedinuser->role_id,
            'directory' => '>'. $param['request']->getParam('controller') . '>'.$param['request']->getParam('action'), 
            'action' => $param['request']->getParam('action'),
            'status' => 'success', 
        ]); 
    }
}
