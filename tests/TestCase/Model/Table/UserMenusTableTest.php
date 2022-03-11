<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserMenusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserMenusTable Test Case
 */
class UserMenusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserMenusTable
     */
    protected $UserMenus;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserMenus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserMenus') ? [] : ['className' => UserMenusTable::class];
        $this->UserMenus = $this->getTableLocator()->get('UserMenus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserMenus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UserMenusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
