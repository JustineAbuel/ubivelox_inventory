<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Rule\IsUnique;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\HasMany $Items
 *
 * @method \App\Model\Entity\Category newEmptyEntity()
 * @method \App\Model\Entity\Category newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CategoriesTable extends Table
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

        $this->setTable('categories');
        $this->setDisplayField('category_name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_added' => 'new',
                    'date_updated' => 'always',
                ],
            ]
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'category_id',
        ]);

        $this->hasMany('Subcategories', [
            'foreignKey' => 'category_id',
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
            ->scalar('category_name')
            ->maxLength('category_name', 255)
            ->requirePresence('category_name', 'create')
            ->notEmptyString('category_name');

        $validator
            ->scalar('category_description')
            ->allowEmptyString('category_description');

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

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['category_name'], 'Category name already exists'));

        return $rules;
    }
}
