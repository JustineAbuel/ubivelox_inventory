<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubcategoriesFixture
 */
class SubcategoriesFixture extends TestFixture
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
                'category_id' => 1,
                'subcategory_name' => 'Lorem ipsum dolor sit amet',
                'subcategory_description' => 'Lorem ipsum dolor sit amet',
                'date_added' => '2022-03-14 01:33:52',
                'added_by' => 1,
                'date_updated' => '2022-03-14 01:33:52',
                'updated_by' => 1,
            ],
        ];
        parent::init();
    }
}
