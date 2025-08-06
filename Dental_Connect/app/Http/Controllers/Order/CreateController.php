<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\Order;
use Illuminate\Http\Request;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $dentists = Dentist::all();
        return view('order.create', compact('dentists'));
    }
}
