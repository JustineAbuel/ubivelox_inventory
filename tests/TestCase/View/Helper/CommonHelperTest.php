<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\CommonHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\CommonHelper Test Case
 */
class CommonHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\CommonHelper
     */
    protected $Common;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Common = new CommonHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Common);

        parent::tearDown();
    }
}
