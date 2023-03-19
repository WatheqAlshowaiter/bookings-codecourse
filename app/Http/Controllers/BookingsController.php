<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Employee;
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
        $service = Service::find(2);

        $employee = Employee::find(1);

        $slots = $employee->availableTimeSlots($schedule, $service);

        return view('bookings.create', [
            'slots' => $slots,
        ]);
    }
}
