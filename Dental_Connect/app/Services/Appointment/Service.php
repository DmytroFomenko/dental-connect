<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Service
{
    public function store(array $data): Appointment
    {
        $user = Auth::user();

        // Формуємо begin_time та end_time як datetime, поєднуючи дату і час
        $beginDateTime = $data['date'] . ' ' . $data['begin_time'] . ':00';
        $endDateTime = $data['date'] . ' ' . $data['end_time'] . ':00';

        // Формуємо масив для створення запису, додаючи dentist_id
        $appointmentData = [
            'dentist_id' => $user->dentist->id,
            'patient_name' => $data['patient_name'],
            'phone_number' => $data['phone_number'],
            'begin_time' => $beginDateTime,
            'end_time' => $endDateTime,
        ];

        return Appointment::create($appointmentData);
    }

    public function setOrderProcessedById(int $id): void
    {
        $order = Order::find($id);

        if ($order) {
            $order->status = 'processed';
            $order->save();
        }
    }

    // App\Services\AppointmentService.php

    public function getAppointmentsForDentist()
    {
        $user = Auth::user();

        return Appointment::where('dentist_id', $user->dentist->id)
            ->where('begin_time', '>=', Carbon::now('Europe/Kyiv'))
            ->orderBy('begin_time')
            ->paginate(10);
    }



}
