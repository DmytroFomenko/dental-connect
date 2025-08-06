<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Requests\Appointment\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {

        $validated = $request->validated();

        $this->service->store($validated);

        $this->service->setOrderProcessedById($validated['order_id']);

        return redirect()->route('dentist.index')->with('success', 'Appointment created successfully!');;
    }
}
