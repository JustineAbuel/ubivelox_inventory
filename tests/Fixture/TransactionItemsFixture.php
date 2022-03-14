<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransactionItemsFixture
 */
class TransactionItemsFixture extends TestFixture
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
                'transaction_id' => 1,
                'item_id' => 1,
                'quantity' => 1,
                'internal_warranty' => '2022-03-14',
            ],
        ];
        parent::init();
    }
}
