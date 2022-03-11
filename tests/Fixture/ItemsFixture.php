<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemsFixture
 */
class ItemsFixture extends TestFixture
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
                'item_name' => 'Lorem ipsum dolor sit amet',
                'serial_no' => 'Lorem ipsum dolor sit amet',
                'item_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'issued_date' => '2022-03-07 05:24:26',
                'warranty' => '2022-03-07',
                'quantity' => 1,
                'supplier_id' => 1,
                'item_type_id' => 1,
                'quality' => 1,
                'remarks' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'part_no' => 'Lorem ipsum dolor sit amet',
                'operating_system' => 'Lorem ipsum dolor sit amet',
                'kernel' => 'Lorem ipsum dolor sit amet',
                'header_type' => 'Lorem ipsum dolor sit amet',
                'firmware' => 'Lorem ipsum dolor sit amet',
                'features' => 'Lorem ipsum dolor sit amet',
                'date_added' => '2022-03-07 05:24:26',
                'added_by' => 1,
                'date_updated' => '2022-03-07 05:24:26',
                'updated_by' => 1,
                'trashed' => '2022-03-07 05:24:26',
            ],
        ];
        parent::init();
    }
}
