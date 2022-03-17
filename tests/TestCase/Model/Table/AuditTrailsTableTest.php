<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuditTrailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditTrailsTable Test Case
 */
class AuditTrailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditTrailsTable
     */
    protected $AuditTrails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AuditTrails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AuditTrails') ? [] : ['className' => AuditTrailsTable::class];
        $this->AuditTrails = $this->getTableLocator()->get('AuditTrails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AuditTrails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AuditTrailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AuditTrailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
