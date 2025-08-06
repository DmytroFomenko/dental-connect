<?php

namespace App\Services\Dentist;

use App\Models\Dentist;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Storage;

class Service
{


    public function updateDentist(Dentist $dentist, array $data): void
    {
        $oldPhotoName = $dentist->photo_name ?? null;
        $newPhotoName = null;

        if (isset($data['photo'])) {
            $originalName = pathinfo($data['photo']->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $data['photo']->getClientOriginalExtension();
            $timestamp = time();
            $newPhotoName = Str::slug($originalName) . '_' . $timestamp . '.' . $extension;

            $data['photo']->storeAs('dentist_photos', $newPhotoName, 'public');
            $data['photo_name'] = $newPhotoName;
        }

        unset($data['photo']);

        try {
            $dentist->update($data);

            // If the update is successful and there is a new photo, delete the old one.
            if ($newPhotoName && $oldPhotoName && $oldPhotoName !== $newPhotoName) {
                Storage::disk('public')->delete('dentist_photos/' . $oldPhotoName);
            }

        } catch (Exception $e) {
            // In case of an error, delete the new photo if it was saved.
            if ($newPhotoName) {
                Storage::disk('public')->delete('dentist_photos/' . $newPhotoName);
            }
            throw $e;
        }
    }


    public function getOrdersForDentist(int $dentistId)
    {
        return Order::where('dentist_id', $dentistId)
            ->orderByRaw("CASE WHEN status = 'new' THEN 0 ELSE 1 END") // new -> 0, processed -> 1
            ->orderByDesc('created_at')
            ->paginate(10);
    }


    public function toggleOrderStatus(Order $order): void
    {
        $order->status = $order->status === 'processed' ? 'new' : 'processed';
        $order->save();
    }

    public function getAllDentists()
    {
        return Dentist::orderBy('name')->get();
    }


}
