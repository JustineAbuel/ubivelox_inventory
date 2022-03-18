<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AuditTrails Model
 *
 * @method \App\Model\Entity\AuditTrail newEmptyEntity()
 * @method \App\Model\Entity\AuditTrail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail get($primaryKey, $options = [])
 * @method \App\Model\Entity\AuditTrail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AuditTrail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AuditTrail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AuditTrail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AuditTrail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AuditTrail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AuditTrail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AuditTrailsTable extends Table
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

        $this->setTable('audit_trails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('level')
            ->maxLength('level', 30)
            ->allowEmptyString('level');

        $validator
            ->scalar('channel')
            ->maxLength('channel', 20)
            ->allowEmptyString('channel');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 50)
            ->allowEmptyString('ip_address');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->allowEmptyString('username');

        $validator
            ->scalar('role')
            ->maxLength('role', 50)
            ->allowEmptyString('role');

        $validator
            ->scalar('directory')
            ->allowEmptyString('directory');

        $validator
            ->scalar('action')
            ->maxLength('action', 50)
            ->allowEmptyString('action');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->dateTime('timestamp')
            ->allowEmptyDateTime('timestamp');

        $validator
            ->scalar('log')
            ->allowEmptyString('log');

        return $validator;
    }
 
}
