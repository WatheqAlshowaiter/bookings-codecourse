<?php

namespace App\Bookings\Filters;

use App\Bookings\Filter;
use App\Bookings\TimeSlotGenerator;
use App\Models\Appointment;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class AppointmentFilter implements Filter
{
    public function __construct(
        public Collection $appointments
    ) {
    }

    public function apply(TimeSlotGenerator $generator, CarbonPeriod $interval)
    {
        $interval->addFilter(function ($slot) use ($generator) {
            foreach ($this->appointments as $appointment) {
                if (
                    $slot->between(
                        $appointment->date->setTimeFrom(
                            $appointment->start_time->subMinutes($generator->service->duration)
                        ),
                        $appointment->date->setTimeFrom(
                            $appointment->end_time
                        ),
                    )
                ) {
                    return false;
                }
            }

            return true;
        });
    }
}
