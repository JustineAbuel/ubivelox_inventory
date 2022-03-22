<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutgoingTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutgoingTable Test Case
 */
class OutgoingTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutgoingTable
     */
    protected $Outgoing;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Outgoing',
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
        $config = $this->getTableLocator()->exists('Outgoing') ? [] : ['className' => OutgoingTable::class];
        $this->Outgoing = $this->getTableLocator()->get('Outgoing', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Outgoing);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OutgoingTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OutgoingTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
