<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\TransactionType;
use Authorization\IdentityInterface;

/**
 * TransactionType policy
 */
class TransactionTypePolicy
{
    public function canIndex(IdentityInterface $user, TransactionType $transactionType)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add TransactionType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionType $transactionType
     * @return bool
     */
    public function canAdd(IdentityInterface $user, TransactionType $transactionType)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit TransactionType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionType $transactionType
     * @return bool
     */
    public function canEdit(IdentityInterface $user, TransactionType $transactionType)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete TransactionType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionType $transactionType
     * @return bool
     */
    public function canDelete(IdentityInterface $user, TransactionType $transactionType)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view TransactionType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\TransactionType $transactionType
     * @return bool
     */
    public function canView(IdentityInterface $user, TransactionType $transactionType)
    {
        return $this->isAllowed($user, 'view');
    }

    protected function isAllowed($user, $action)
    { 
        // return $user->role_id === 1;
        //1=Dev, 2=HR, 3=ITSupport, 4=Sales 
 
        switch ($user->role_id) {
            case 1:
                //Dev 
                $allowed = true;
                break; 
            case 2: 
                //HR
                
               
                $allowed = false;
                break;
                
            case 3: 
                //IT Support
                $allowed = true;
                break;
            
            case 4:
                //Sales 
                
                $allowed = false;
                 
                break;
            default:
                $allowed = false;
                break;
        }
        return $allowed;
    }
}
