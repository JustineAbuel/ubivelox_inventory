<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\AuthorizeHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\AuthorizeHelper Test Case
 */
class AuthorizeHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\AuthorizeHelper
     */
    protected $Authorize;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Authorize = new AuthorizeHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Authorize);

        parent::tearDown();
    }
}
