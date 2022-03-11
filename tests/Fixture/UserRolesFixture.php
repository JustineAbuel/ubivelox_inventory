<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserRolesFixture
 */
class UserRolesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'role_name' => 'Lorem ipsum dolor sit amet',
                'date_added' => '2022-03-07 02:26:11',
                'added_by' => 1,
                'date_updated' => '2022-03-07 02:26:11',
                'updated_by' => 1,
            ],
        ];
        parent::init();
    }
}
