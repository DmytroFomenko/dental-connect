<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\Service;

class BaseController extends Controller {
    public $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }
}
