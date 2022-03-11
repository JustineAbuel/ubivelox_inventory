<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ItemTypeType;
use Authorization\IdentityInterface;

/**
 * ItemType policy
 */
class ItemTypePolicy
{
    public function canIndex(IdentityInterface $user, ItemType $itemType)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add ItemType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemType $itemType
     * @return bool
     */
    public function canAdd(IdentityInterface $user, ItemType $itemType)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit ItemType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemType $itemType
     * @return bool
     */
    public function canEdit(IdentityInterface $user, ItemType $itemType)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete ItemType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemType $itemType
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ItemType $itemType)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view ItemType
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemType $itemType
     * @return bool
     */
    public function canView(IdentityInterface $user, ItemType $itemType)
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
