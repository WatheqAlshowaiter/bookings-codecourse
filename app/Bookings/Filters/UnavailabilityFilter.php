<?php

namespace App\Bookings\Filters;

use App\Bookings\Filter;
use App\Bookings\TimeSlotGenerator;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class UnavailabilityFilter implements Filter
{
    public function __construct(
        public Collection $unavailabilities,
    ) {
    }

    public function apply(TimeSlotGenerator $generator, CarbonPeriod $interval)
    {
        $interval->addFilter(function ($slot) use ($generator) {
            foreach ($this->unavailabilities as $unavailability) {
                if (
                    $slot->between(
                        $unavailability->schedule->date->setTimeFrom(
                            $unavailability->start_time->subMinutes(
                                $generator->service->duration - $generator::INCREMENT
                            )
                        ),
                        $unavailability->schedule->date->setTimeFrom(
                            $unavailability->end_time->subMinutes($generator::INCREMENT)
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
