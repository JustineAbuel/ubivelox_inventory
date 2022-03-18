<?php

namespace App\Log\Engine;
use Cake\ORM\TableRegistry;
use Cake\Log\Engine\BaseLog;

class DatabaseLog extends BaseLog
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        // ...
    }

    public function log($level, $message, array $context = [])
    { 
        $auditTrails = TableRegistry::get('AuditTrails');

        $data = [
            'level' => $level,
            'channel' => $context['channel'],
            'ip_address' => $context['ip_address'],
            'username' => $context['username'],
            'role' => $context['role'],
            'directory' => $context['directory'],
            'action' => $context['action'],
            'status' => $context['status'],
            'timestamp' => date('Y-m-d H:i:s'),
            'log' => $message,
        ]; //add here data relevant to your logs and the db structure you are using
        // dd($data);
        
        $logEntry = $auditTrails->newEntity($data); 
        // dd($logEntry);
        if(!($auditTrails->save($logEntry))){
            throw new \LogicException('Could not store the log into the DB.');
        } 

    }
} 