<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Requests\Dentist\StoreRequest;
use App\Services\Dentist\Service;

class UpdateController extends BaseController
{
    public function __invoke(StoreRequest $request, Service $service)
    {
        $dentist = auth()->user()->dentist;

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo');
        }

        $service->updateDentist($dentist, $data);

        return redirect()->route('dentist.edit')->with('success', 'Profile updated successfully!');
    }
}
