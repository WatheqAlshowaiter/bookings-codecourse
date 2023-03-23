<div class="bg-white rounded-lg">
    <div class="flex items-center justify-center relative">
        @if ($this->weekIsGreaterThanCurrent)
            <button type="button" class="p-4 absolute left-0 top-0" wire:click="decrementCalendarWeek">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-gray-300 hover:text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
        @endif
        <div class="text-lg font-semibold p-4">
            {{ $this->calendarStartDate->format('M Y') }}
        </div>
        <button type="button" class="p-4 absolute right-0 top-0" wire:click="incrementCalendarWeek">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-300 hover:text-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>
    <div class="flex justify-between items-center px-3 border-b border-gray-200 pb-2">
        @foreach ($this->calendarWeekInterval as $day)
            <button wire:click="setDate({{ $day->timestamp }})" type="button"
                class="text-center group cursor-pointer focus:outline-none">
                <div class="text-xs leading-none mb-2 text-gray-700">
                    {{ $day->format('D') }}
                </div>

                <div
                    class="text-lg leading-none p-1 rounded-full group-hover:bg-gray-200 w-9 h-9 flex justify-center items-center {{ $date === $day->timestamp ? 'bg-gray-200' : '' }}">
                    {{ $day->format('d') }}
                </div>
            </button>
        @endforeach

    </div>

    <div class="max-h-52 overflow-y-scroll">
        <input type="radio" name="time" id="" value="" class="sr-only" />
        <label for=""
            class="w-full text-left focus-outline-none px-4 py-2 flex items-center cursor-pointer border-b border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="w-4 h-4 mr-2 text-gray-700">
                <path fill-rule="evenodd"
                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                    clip-rule="evenodd" />
            </svg>
            09:00am
        </label>

        <div class="text-center text-gray-700 px-4 py-2">
            No available slots
        </div>
    </div>
</div>
