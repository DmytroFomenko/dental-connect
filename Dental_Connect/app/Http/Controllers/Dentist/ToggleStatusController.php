<?php

namespace App\Http\Controllers\Dentist;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class ToggleStatusController extends BaseController
{
    public function __invoke(Order $order): RedirectResponse
    {
        $this->service->toggleOrderStatus($order);

        return redirect()->back();
    }
}
