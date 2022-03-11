<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserAccessTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserAccessTable Test Case
 */
class UserAccessTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserAccessTable
     */
    protected $UserAccess;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserAccess',
        'app.Roles',
        'app.Menus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserAccess') ? [] : ['className' => UserAccessTable::class];
        $this->UserAccess = $this->getTableLocator()->get('UserAccess', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserAccess);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UserAccessTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
