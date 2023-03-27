<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Livewire\Component;

class CreateBooking extends Component
{
    public $employees;

    public $state = [
        'service' => '',
        'employee' => '',
        'time' => '',
        'name' => '',
        'email' => '',
    ];

    protected $listeners = [
        'updated-booking-time' => 'setTime',
    ];

    protected function rules()
    {
        return [
            'state.service' => ['required', 'exists:services,id'],
            'state.employee' => ['required', 'exists:employees,id'],
            'state.time' => ['required', 'numeric'],
            'state.name' => ['required', 'string'],
            'state.email' => ['required', 'email'],
        ];
    }

    public function mount()
    {
        $this->employees = collect();
    }

    public function createBooking()
    {
        $this->validate();

        $bookingFields = [
            'date' => $this->timeObject->toDateString(),
            'start_time' => $this->timeObject->toTimeString(),
            'end_time' => $this->timeObject->clone()->addMinutes(
                $this->selectedService->duration
            )->toTimeString(),
            'client_name' => $this->state['name'],
            'client_email' => $this->state['email'],
        ];

        $appointment = Appointment::make($bookingFields); // `make` does not persist in database

        $appointment->service()->associate($this->selectedService);
        $appointment->employee()->associate($this->selectedEmployee);

        $appointment->save();
    }

    public function setTime($time)
    {
        $this->state['time'] = $time;
    }

    public function updatedStateService($serviceId)
    {
        $this->state['employee'] = '';

        if (! $serviceId) {
            $this->employees = collect();

            return;
        }

        $this->clearTime();

        $this->employees = $this->selectedService->employees;
    }

    public function updatedStateEmployee()
    {
        $this->clearTime();
    }

    public function clearTime()
    {
        $this->state['time'] = '';
    }

    public function getSelectedServiceProperty()
    {
        if (! $this->state['service']) {
            return null;
        }

        return Service::find($this->state['service']);
    }

    public function getSelectedEmployeeProperty()
    {
        if (! $this->state['employee']) {
            return null;
        }

        return Employee::find($this->state['employee']);
    }

    public function getHasDetailsToBookProperty()
    {
        return $this->state['service']
            && $this->state['employee']
            && $this->state['time'];
    }

    public function getTimeObjectProperty()
    {
        return Carbon::createFromTimestamp($this->state['time']);
    }

    public function render()
    {
        $services = Service::all();

        return view('livewire.create-booking', [
            'services' => $services,
        ])->layout('layouts.guest');
    }
}
