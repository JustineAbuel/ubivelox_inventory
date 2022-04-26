<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Validation\Validation;
use Laminas\Diactoros\UploadedFile;

/**
 * Users Model
 *
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('UserRoles', [
            'foreignKey' => 'role_id',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Incoming', [
            'foreignKey' => 'added_by',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        // $validator
        //     ->scalar('newpassword', 'password'); 
        // $validator
        //     ->sameAs('retypepassword', 'newpassword'); 

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 255)
            ->requirePresence('firstname', 'create')
            ->notEmptyString('firstname');

        $validator
            ->scalar('middlename')
            ->maxLength('middlename', 255)
            ->allowEmptyString('middlename');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 255)
            ->requirePresence('lastname', 'create')
            ->notEmptyString('lastname');

        $validator
            ->scalar('contactno')
            ->requirePresence('contactno', 'create')
            ->notEmptyString('contactno');

        $validator
            ->dateTime('date_added')
            ->allowEmptyDateTime('date_added');

        $validator
            ->integer('added_by')
            ->allowEmptyString('added_by');

        $validator
            ->dateTime('date_updated')
            ->allowEmptyDateTime('date_updated');

        $validator
            ->integer('updated_by')
            ->allowEmptyString('updated_by');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->date('password_expiration')
            ->allowEmptyDate('password_expiration');

        $validator
            ->dateTime('trashed')
            ->allowEmptyDateTime('trashed');

        $validator
            ->allowEmptyFile('image')
            // ->uploadedFile('image', [
            //     'types' => ['image/png'], // only PNG image files
            //     'minSize' => 1024, // Min 1 KB
            //     'maxSize' => 1024 * 1024 // Max 1 MB
            // ])
            ->add('image', 'file', [
                'rule' => ['uploadedFile', ['types' => ['image/png', 'image/jpeg', 'application/pdf']]], // It's what I expect to check
                'message' => __(".PNG, .JPG, .JPEG file extensions only")
            ]);
        // ->add('image', 'file',[
        //         [
        //             'rule' => ['mimeType', ['image/png','image/jpg','image/jpeg'],
        //             'message' => '.PNG, .JPG, .JPEG file extensions only'] 
        //         ], 
        //         [
        //             'rule' => ['fileSize', '<=', '1KB' ],
        //             'message' => 'Image size must be less than 1'
        //         ]
        //     ]);
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('role_id', 'UserRoles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
