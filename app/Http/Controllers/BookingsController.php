<?php

namespace App\Http\Controllers;

use App\Bookings\TimeSlotGenerator;
use App\Models\Schedule;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $schedule = Schedule::find(1);

        $slots = (new TimeSlotGenerator($schedule))->get();

        return view('bookings.create', [
            'slots' => $slots
        ]);
    }
}
