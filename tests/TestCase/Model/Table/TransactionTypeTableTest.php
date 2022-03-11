<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransactionTypeTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransactionTypeTable Test Case
 */
class TransactionTypeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransactionTypeTable
     */
    protected $TransactionType;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TransactionType',
        'app.Transactions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TransactionType') ? [] : ['className' => TransactionTypeTable::class];
        $this->TransactionType = $this->getTableLocator()->get('TransactionType', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TransactionType);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TransactionTypeTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
