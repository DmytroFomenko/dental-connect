<?php

namespace App\Services\Order;

use App\Models\Order;

class Service
{
    public function store(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order;
    }

}
