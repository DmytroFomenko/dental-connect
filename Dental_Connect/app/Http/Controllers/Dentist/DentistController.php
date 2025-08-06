<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Services\Dentist\Service;

class DentistController extends Controller
{
    protected Service $dentistService;

    public function __construct(Service $dentistService)
    {
        $this->dentistService = $dentistService;
    }

    public function index()
    {
        $dentists = $this->dentistService->getAllDentists();

        return view('dentist.dentists', compact('dentists'));
    }
}

