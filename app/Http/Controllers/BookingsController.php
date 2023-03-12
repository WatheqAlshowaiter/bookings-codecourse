<?php

namespace App\Http\Controllers;

use App\Bookings\Filters\SlotsPassedTodayFilter;
use App\Bookings\TimeSlotGenerator;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $schedule = Schedule::find(1);
        $service = Service::find(1);

        $slots = (new TimeSlotGenerator($schedule, $service))
            ->applyFilters([
                new SlotsPassedTodayFilter(),
            ])
            ->get();

        return view('bookings.create', [
            'slots' => $slots,
        ]);
    }
}
