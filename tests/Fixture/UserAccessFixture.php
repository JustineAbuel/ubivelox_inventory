<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserAccessFixture
 */
class UserAccessFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'user_access';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'role_id' => 1,
                'menu_id' => 1,
            ],
        ];
        parent::init();
    }
}
