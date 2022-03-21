<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IncomingTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IncomingTable Test Case
 */
class IncomingTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IncomingTable
     */
    protected $Incoming;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Incoming',
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
        $config = $this->getTableLocator()->exists('Incoming') ? [] : ['className' => IncomingTable::class];
        $this->Incoming = $this->getTableLocator()->get('Incoming', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Incoming);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\IncomingTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\IncomingTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
