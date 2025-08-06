<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Services\Appointment\Service;

class BaseController extends Controller {
    public $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }
}
