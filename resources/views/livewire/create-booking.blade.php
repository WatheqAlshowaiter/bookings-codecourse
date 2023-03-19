<div class="bg-gray-200 max-w-sm mx-auto m-6 p-5 rounded-lg">
    <form wire:submit.prevent="createBooking">
        <div class="mb-6">
            <label for="service" class="inline-block text-gray-700 font-bold mb-2">Select service</label>
            <select name="service" id="service" class="bg-white h-10 w-full border-none rounded-lg"
                wire:model="state.service">
                <option value="">Select a service</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="employee" class="inline-block text-gray-700 font-bold mb-2">Select employee</label>
            <select name="employee" id="service" class="bg-white h-10 w-full border-none rounded-lg"
                wire:model="state.employee">
                <option value="">Select an employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
