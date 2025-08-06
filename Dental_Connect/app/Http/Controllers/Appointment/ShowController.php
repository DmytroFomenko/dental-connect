<?php

namespace App\Http\Controllers\Appointment;


class ShowController extends BaseController
{
    public function __invoke()
    {
        $appointments = $this->service->getAppointmentsForDentist();

        return view('appointment.show', compact('appointments'));

    }
}
