<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransactionItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransactionItemsTable Test Case
 */
class TransactionItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransactionItemsTable
     */
    protected $TransactionItems;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TransactionItems',
        'app.Transactions',
        'app.Items',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TransactionItems') ? [] : ['className' => TransactionItemsTable::class];
        $this->TransactionItems = $this->getTableLocator()->get('TransactionItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TransactionItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TransactionItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TransactionItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
