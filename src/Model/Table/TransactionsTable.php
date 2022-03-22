<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transactions Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TransactionTypesTable&\Cake\ORM\Association\BelongsTo $TransactionTypes
 * @property \App\Model\Table\TransactionItemsTable&\Cake\ORM\Association\HasMany $TransactionItems
 *
 * @method \App\Model\Entity\Transaction newEmptyEntity()
 * @method \App\Model\Entity\Transaction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transaction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Transaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TransactionsTable extends Table
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

        //Set Timestamp for Adding transaction
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_added' => 'new',
                    //'cancelled' => 'always',
                ]
            ]
        ]);

        $this->setTable('transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TransactionType', [
            'foreignKey' => 'transaction_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('TransactionStatus', [
            'foreignKey' => 'status',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('TransactionItems', [
            'foreignKey' => 'transaction_id',
        ]);
        $this->hasMany('Outgoing', [
            'foreignKey' => 'transaction_id',
        ]);
        $this->belongsTo('Company', [
            'foreignKey' => 'company_to',
            'joinType' => 'INNER'
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
            ->scalar('transaction_code')
            ->maxLength('transaction_code', 255)
            ->requirePresence('transaction_code', 'create')
            ->notEmptyString('transaction_code');

        $validator
            ->integer('company_from')
            ->requirePresence('company_from', 'create')
            ->notEmptyString('company_from');

        $validator
            ->integer('transaction_type_id')
            ->requirePresence('transaction_type_id', 'create')
            ->notEmptyString('transaction_type_id');

        $validator
            ->integer('company_to')
            ->requirePresence('company_to', 'create')
            ->notEmptyString('company_to');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->allowEmptyString('subject');

        $validator
            ->scalar('received_by')
            ->maxLength('received_by', 255)
            ->allowEmptyString('received_by');

        $validator
            ->dateTime('received_date')
            ->allowEmptyDateTime('received_date');

        $validator
            ->integer('status')
            ->allowEmptyString('status')
            ->notEmptyString('status');

        $validator
            ->dateTime('date_added')
            ->allowEmptyDateTime('date_added');

        $validator
            ->integer('added_by')
            ->allowEmptyString('added_by');

        $validator
            ->dateTime('cancelled')
            ->allowEmptyDateTime('cancelled');

        $validator
            ->integer('cancelled_by')
            ->allowEmptyString('cancelled_by');

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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('transaction_type_id', 'TransactionType'), ['errorField' => 'transaction_type_id']);

        return $rules;
    }
    public function generate_transcode(){
        $str1 = str_shuffle(random_bytes(20).sha1("Ub1v3L0XpHiL1pPiN3$iNc.!"));
        $str2 = date("Y-m-d H:i:s").md5($str1);
        return strtoupper("REFNO-".substr(str_shuffle(md5(base64_encode($str2))),0, 6)); //generate unique ref code for main transaction
    }

}
