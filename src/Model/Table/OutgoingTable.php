<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Outgoing Model
 *
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\BelongsTo $Transactions
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\Outgoing newEmptyEntity()
 * @method \App\Model\Entity\Outgoing newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Outgoing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Outgoing get($primaryKey, $options = [])
 * @method \App\Model\Entity\Outgoing findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Outgoing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Outgoing[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Outgoing|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Outgoing saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Outgoing[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Outgoing[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Outgoing[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Outgoing[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class OutgoingTable extends Table
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

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_added' => 'new', 
                ] ,
                'Items.updated' => [
                    'date_updated' => 'always'
                ]
            ]
        ]);

        $this->setTable('outgoing');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Transactions', [
            'foreignKey' => 'transaction_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('TransactionItems', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('TransactionStatus', [
            'foreignKey' => 'status',
            'joinType' => 'INNER',
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
            ->integer('transaction_id')
            ->requirePresence('transaction_id', 'create')
            ->allowEmptyString('transaction_id');

        $validator
            ->integer('item_id')
            ->requirePresence('item_id', 'create')
            ->allowEmptyString('item_id');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->dateTime('date_added')
            ->allowEmptyDateTime('date_added');

        $validator
            ->scalar('added_by')
            ->maxLength('added_by', 50)
            ->allowEmptyString('added_by');

        $validator
            ->dateTime('date_updated')
            ->allowEmptyDateTime('date_updated');

        $validator
            ->scalar('updated_by')
            ->maxLength('updated_by', 50)
            ->allowEmptyString('updated_by');

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
        $rules->add($rules->existsIn('transaction_id', 'Transactions'), ['errorField' => 'transaction_id']);
        $rules->add($rules->existsIn('item_id', 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
