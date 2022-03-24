<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\UserRole;
use Authorization\IdentityInterface;

/**
 * UserRole policy
 */
class UserRolePolicy
{
    public function canIndex(IdentityInterface $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add UserRole
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\userRole $userRole
     * @return bool
     */
    public function canAdd(IdentityInterface $user, UserRole $userRole)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit UserRole
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\userRole $userRole
     * @return bool
     */
    public function canEdit(IdentityInterface $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete UserRole
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\userRole $userRole
     * @return bool
     */
    public function canDelete(IdentityInterface $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view UserRole
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\userRole $userRole
     * @return bool
     */
    public function canView(IdentityInterface $user, UserRole $userRole)
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
 
            case 5:
                //Logistics 
                $allowed = false;
                break;

            default:
                $allowed = false;
                break;
        }
        return $allowed;
    }
}
