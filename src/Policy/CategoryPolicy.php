<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Category;
use Authorization\IdentityInterface;

/**
 * Category policy
 */
class CategoryPolicy
{
    public function canIndex(IdentityInterface $user, Category $category)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add category
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Category $category
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Category $category)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit category
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Category $category
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Category $category)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete category
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Category $category
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Category $category)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view category
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Category $category
     * @return bool
     */
    public function canView(IdentityInterface $user, Category $category)
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
                
                $allowedView = ['index', 'view','add', 'edit'];
               
                if(in_array($action, $allowedView)){ 
                    $allowed = true;
                } 
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
