<?php

namespace App\Http\Controllers\Dentist;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController {

    public function __invoke() {

        $dentist = Auth::user()->dentist;
        if (!$dentist) {
            abort(403, 'Access denied: No dentist found for this user.');
        }

        $orders = $this->service->getOrdersForDentist($dentist->id);

        return view('dentist.index', compact('orders', 'dentist'));
    }
}
