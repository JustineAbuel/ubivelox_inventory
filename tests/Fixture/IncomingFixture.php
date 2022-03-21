<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IncomingFixture
 */
class IncomingFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'incoming';
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
                'item_id' => 1,
                'quantity' => 1,
                'date_added' => '2022-03-21 15:50:13',
                'added_by' => 1,
                'date_updated' => '2022-03-21 15:50:13',
                'updated_by' => 1,
            ],
        ];
        parent::init();
    }
}
