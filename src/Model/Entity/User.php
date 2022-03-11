<?php
declare(strict_types=1);

namespace App\Model\Entity;
 
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityInterface;
use Authorization\Policy\ResultInterface;
/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $firstname
 * @property string|null $middlename
 * @property string $lastname
 * @property int|null $contactno
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property int|null $added_by
 * @property \Cake\I18n\FrozenTime|null $date_updated
 * @property int|null $updated_by
 * @property int|null $role_id
 *
 * @property \App\Model\Entity\UserRole $user_role
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class User extends Entity implements IdentityInterface
{
    /**
     * Authorization\IdentityInterface method
     */
    public function can($action, $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function canResult($action, $resource): ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    /**
     * Authorization\IdentityInterface method
     */
    public function applyScope($action, $resource)
    {
        return $this->authorization->applyScope($this, $action, $resource);
    }
    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;

        return $this;
    }
    /**
     * Authentication\IdentityInterface method
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * Authentication\IdentityInterface method
     */
    public function getOriginalData()
    {
        return $this;
    }
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'email' => true,
        'password' => true,
        'firstname' => true,
        'middlename' => true,
        'lastname' => true,
        'contactno' => true,
        'date_added' => true,
        'added_by' => true,
        'date_updated' => true,
        'updated_by' => true,
        'role_id' => true,
        'user_role' => true,
        'transactions' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }

    public function canAccess()
    {
        return true;
    }

    // public function isAllowed($action)
    // { 
    //     //1=Dev, 2=HR, 3=ITSupport, 4=Sales 
    //     $allowed = false;
    //     switch ($this->role_id) {
    //         case 1:
    //             //Dev 
    //             $allowed = true;
    //             break; 
    //         case 2:
    //             //HR 

    //             if(in_array($action, ['index', 'view'])){
    //                 return true;
    //             }
    //             break;
                
    //         case 3:
    //             //IT Support
    //             $allowed = true;
    //             break;
            
    //         case 4:
    //             //Sales
                
    //             $allowed = false;
    //             break;
    //         default:
    //             $allowed = false;
    //             break;
    //     }
    //     return $allowed;
    // }
}
