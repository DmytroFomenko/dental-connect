<?php

namespace App\Http\Controllers\Dentist;

use Illuminate\Support\Facades\Auth;

class EditController extends BaseController
{
    public function __invoke()
    {
        $dentist = Auth::user()->dentist;

        return view('dentist.edit', compact('dentist'));
    }
}
