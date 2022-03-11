<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemTypeTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemTypeTable Test Case
 */
class ItemTypeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemTypeTable
     */
    protected $ItemType;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ItemType',
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
        $config = $this->getTableLocator()->exists('ItemType') ? [] : ['className' => ItemTypeTable::class];
        $this->ItemType = $this->getTableLocator()->get('ItemType', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ItemType);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ItemTypeTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
