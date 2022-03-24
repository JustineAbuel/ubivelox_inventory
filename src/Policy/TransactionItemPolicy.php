<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\TransactionItem;
use Authorization\IdentityInterface;

/**
 * TransactionItem policy
 */
class TransactionItemPolicy
{
    public function canIndex(IdentityInterface $user, TransactionItem $transactionItems)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add Transactions
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionItem $transactionItems
     * @return bool
     */
    public function canAdd(IdentityInterface $user, TransactionItem $transactionItems)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit Transactions
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionItem $transactionItems
     * @return bool
     */
    public function canEdit(IdentityInterface $user, TransactionItem $transactionItems)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete Transactions
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionItem $transactionItems
     * @return bool
     */
    public function canDelete(IdentityInterface $user, TransactionItem $transactionItems)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view Transactions
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionItem $transactionItems
     * @return bool
     */
    public function canView(IdentityInterface $user, TransactionItem $transactionItems)
    {
        return $this->isAllowed($user, 'view');
    }

    protected function isAllowed($user, $action)
    { 
        // return $user->role_id === 1;
        //1=Dev, 2=HR, 3=ITSupport, 4=Sales 

        $allowed = false;
        switch ($user->role_id) {
            case 1:
                //Dev 
                $allowed = true;
                break; 
            case 2: 
                //HR
                
                $allowedView = ['index', 'view'];
               
                if(in_array($action, $allowedView)){ 
                    $allowed = true;
                }  
                break;
                
            case 3: 
                //IT Support
                $allowed = true;
                break;
            
            case 4:
                //Sales 
                $allowedView = ['index', 'view','add', 'edit'];
               
                if(in_array($action, $allowedView)){ 
                    $allowed = true;
                } 
                break;
                  
            case 5:
                //Logistics 
                $allowedView = ['index', 'view'];
               
                if(in_array($action, $allowedView)){ 
                    $allowed = true;
                } 
                break;
            default:
                $allowed = false;
                break;
        }
        return $allowed;
    }
}
