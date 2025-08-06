<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class NoScheduleOverlap implements ValidationRule
{
    protected string $date;
    protected string $beginTime;
    protected string $endTime;
    protected int $dentistId;

    public function __construct(string $date, string $beginTime, string $endTime, int $dentistId)
    {
        $this->date = $date;
        $this->beginTime = $beginTime;
        $this->endTime = $endTime;
        $this->dentistId = $dentistId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $begin = $this->date . ' ' . $this->beginTime;
        $end = $this->date . ' ' . $this->endTime;

        $conflictExists = DB::table('appointments')
            ->whereDate('begin_time', $this->date)
            ->where('dentist_id', $this->dentistId)
            ->where(function ($query) use ($begin, $end) {
                $query->where(function ($q) use ($begin, $end) {
                    $q->where('begin_time', '<', $end)
                        ->where('end_time', '>', $begin);
                });
            })
            ->exists();

        if ($conflictExists) {
            $fail('The selected time slot overlaps with another appointment for this dentist.');
        }
    }
}
