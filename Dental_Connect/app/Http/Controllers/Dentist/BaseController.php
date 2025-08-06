<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Services\Dentist\Service;

class BaseController extends Controller {
    public $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }
}
