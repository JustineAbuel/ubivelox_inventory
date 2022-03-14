<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransactionsFixture
 */
class TransactionsFixture extends TestFixture
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
                'user_id' => 1,
                'transaction_code' => 'Lorem ipsum dolor sit amet',
                'transaction_type_id' => 1,
                'company_from' => 1,
                'company_to' => 1,
                'subject' => 'Lorem ipsum dolor sit amet',
                'received_by' => 'Lorem ipsum dolor sit amet',
                'received_date' => '2022-03-14 08:27:35',
                'status' => 1,
                'date_added' => '2022-03-14 08:27:35',
                'added_by' => 1,
                'cancelled' => '2022-03-14 08:27:35',
                'cancelled_by' => 1,
            ],
        ];
        parent::init();
    }
}
