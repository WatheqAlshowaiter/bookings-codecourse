<?php

namespace App\Http\Livewire;

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

    public function mount()
    {
        $this->employees = collect();
    }

    public function createBooking()
    {
        dd($this->state);
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
