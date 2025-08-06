<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class BeginAfterNow implements ValidationRule
{
    protected string $date;
    protected string $beginTime;

    public function __construct(string $date, string $beginTime)
    {
        $this->date = $date;
        $this->beginTime = $beginTime;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $tz = 'Europe/Kyiv';
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', "{$this->date} {$this->beginTime}", $tz);
            $now = Carbon::now($tz);

            if ($startDateTime->lessThanOrEqualTo($now)) {
                $fail('The :attribute must be a future time.');
            }
        } catch (\Exception $e) {
            $fail('Invalid date or time format.');
        }
    }
}
