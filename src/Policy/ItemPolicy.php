<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Item;
use Authorization\IdentityInterface;

/**
 * Item policy
 */
class ItemPolicy
{ 
    public function canIndex(IdentityInterface $user, Item $item)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Item $item
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Item $item)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Item $item
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Item $item)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Item $item
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Item $item)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Item $item
     * @return bool
     */
    public function canView(IdentityInterface $user, Item $item)
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
