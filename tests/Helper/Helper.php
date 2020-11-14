<?php

namespace Tests\Helper;

use Mapps\Http\Repositories\Mobile\PaystackRepository;
use Mapps\Http\Repositories\Mobile\TransactionRepository;
use Mapps\Models\Transaction;
use Mapps\Models\VendorShop;
use Mapps\Models\VendorShopService;
use Mapps\Services\Notification\Notification;

trait Helper
{
    public function transaction($customerId, $transactionTime, $defaultPrice, $defaultTime, $billingCycle, $paymentType = 1)
    {
        $vendor = factory(VendorShopService::class)->create();

        $data = [
            'customer_id' => $customerId,
            'vendor_id' => $vendor->vendor_id,
            'business_type_id' => $vendor->shop->business_type_id,
            'service_id' => $vendor->service_id,
            'sub_service_id' => null,
            'price' => $defaultPrice,
            'payment_type_id' => $paymentType,
            'last4' => $vendor->shop->last4,
            'default_time' => $defaultTime,
            'billing_cycle' => $billingCycle,
            'user_longitude' => 0.3333,
            'user_latitude' => 3.3333,
        ];

        $newdate = strtotime("-{$transactionTime} minutes", strtotime(date('Y-m-d H:i:s')));
        $newdate = date('Y-m-d H:i:s', $newdate);

        $this->mock(Notification::class)->shouldReceive('sendGroupNotification')->once()->andReturn('request sent');

        $transaction = $this->post('api/v1/transaction', $data)->json();

        $transactionId = $transaction['transaction']['id'];
        $this->mock(Notification::class)->shouldReceive('sendPushNotification')->once()->andReturn('request sent');

        $startData = [
            'location_latitude' => $transaction['transaction']['shop']['location_latitude'],
            'location_longitude' => $transaction['transaction']['shop']['location_longitude'],
            'startTime' => $newdate,
        ];
        $start = $this->put("api/v1/transaction/start/{$transactionId}", $startData)->json()['data'];
        if ($paymentType === 2) {
            $this->mock(PaystackRepository::class)->shouldReceive('pay')->once()->andReturn(true);
        }
        $this->mock(Notification::class)->shouldReceive('sendPushNotification')->once()->andReturn('request sent');

        $response = $this->get("api/v1/transaction/end/{$transactionId}");

        return $response->json()['data'];
    }

    public function firstTransaction($customerId)
    {
        $transaction = app(TransactionRepository::class);

        $vendor = factory(VendorShop::class)->create([
            'user_id' => 99,
            'business_type_id' => 3,
        ]);

        $date = date('Y-m-d H:i:s');
        $newdate = strtotime('-1 hour', strtotime($date));
        $newdate = strtotime('-23 minutes', $newdate);
        $workTime = date('Y-m-d H:i:s', $newdate);

        $data = factory(Transaction::class)->create([
            'customer_id' => $customerId,
            'vendor_id' => $vendor->id,
            'business_type_id' => $vendor->business_type_id,
            'service_id' => 'service101',
            'payment_type_id' => 2,
            'default_time' => 67,
            'price' => 2300,
            'billing_cycle' => false,
        ]);

        $transaction->updateTransactionStatus($data->id, 'started_at', $workTime, 'ONGOING');
        \URL::forceRootUrl("http://www.myapp.com/api/v1/transaction/end/{$data->id}");

        return $transaction->terminateTransaction($data->id);
    }
}
