<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OutgoingFixture
 */
class OutgoingFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'outgoing';
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
                'transaction_id' => 1,
                'item_id' => 1,
                'status' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'date_added' => '2022-03-21 16:27:52',
                'added_by' => 'Lorem ipsum dolor sit amet',
                'date_updated' => '2022-03-21 16:27:52',
                'updated_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
