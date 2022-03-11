<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;


use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;
/**
 * User policy
 */
class UserPolicy 
// implements BeforePolicyInterface 

{
    public function canIndex(IdentityInterface $user, User $resource)
    {
        return $this->isAllowed($user, 'index');
    }
    /**
     * Check if $user can add Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canAdd(IdentityInterface $user, User $resource)
    { 
        return $this->isAllowed($user, 'add');
    }

    /**
     * Check if $user can edit Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canEdit(IdentityInterface $user, User $resource)
    {
        return $this->isAllowed($user, 'edit');
    }

    /**
     * Check if $user can delete Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canDelete(IdentityInterface $user, User $resource)
    {
        return $this->isAllowed($user, 'delete');
    }

    /**
     * Check if $user can view Item
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canView(IdentityInterface $user, User $resource)
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
                // $allowedView = ['index', 'view']; 
                // if(in_array($action, $allowedView)){ 
                //     $allowed = true;
                // }  
                $allowed = true;
                
                break;
                
            case 3:
                //IT Support
                $allowedView = ['index', 'view']; 
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
