<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\ItemTypesTable&\Cake\ORM\Association\BelongsTo $ItemTypes
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 *
 * @method \App\Model\Entity\Item newEmptyEntity()
 * @method \App\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]); 
        $this->belongsTo('Subcategories', [
            'foreignKey' => 'subcategory_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Company', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ItemType', [
            'foreignKey' => 'item_type_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'item_id',
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
            ->scalar('item_name')
            ->maxLength('item_name', 255)
            ->requirePresence('item_name', 'create')
            ->notEmptyString('item_name')  ;

        $validator
            ->scalar('serial_no')
            ->maxLength('serial_no', 255)
            ->allowEmptyString('serial_no');

        $validator
            ->scalar('item_description')
            ->allowEmptyString('item_description');

        $validator
            ->dateTime('issued_date')
            ->allowEmptyDateTime('issued_date');

        $validator
            ->date('manufacturer_warranty')
            ->requirePresence('manufacturer_warranty', 'create')
            ->notEmptyDate('manufacturer_warranty');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->integer('quality')
            ->requirePresence('quality', 'create')
            ->notEmptyString('quality');

        $validator
            ->scalar('remarks')
            ->allowEmptyString('remarks');

        $validator
            ->scalar('part_no')
            ->maxLength('part_no', 255)
            ->allowEmptyString('part_no');

        $validator
            ->scalar('operating_system')
            ->maxLength('operating_system', 255)
            ->allowEmptyString('operating_system');

        $validator
            ->scalar('kernel')
            ->maxLength('kernel', 255)
            ->allowEmptyString('kernel');

        $validator
            ->scalar('header_type')
            ->maxLength('header_type', 255)
            ->allowEmptyString('header_type');

        $validator
            ->scalar('firmware')
            ->maxLength('firmware', 255)
            ->allowEmptyString('firmware');

        $validator
            ->scalar('features')
            ->maxLength('features', 255)
            ->allowEmptyString('features');

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
            ->dateTime('trashed')
            ->allowEmptyDateTime('trashed');

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
        $rules->add($rules->existsIn('category_id', 'Categories'), ['errorField' => 'category_id']); 
        $rules->add($rules->existsIn('subcategory_id', 'Subcategories'), ['errorField' => 'subcategory_id']);
        $rules->add($rules->existsIn('supplier_id', 'Company'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn('item_type_id', 'ItemType'), ['errorField' => 'item_type_id']);
        $rules->add($rules->isUnique(['item_name'], 'Item name already exists'));

        return $rules;
    }

    public function findTrashed(Query $query, array $options){
        return $query->where(['trashed ==' => null]);
    }
}
