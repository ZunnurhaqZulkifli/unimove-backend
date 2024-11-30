<x-filament-panels::page>
    {{ $this->infolist }}
    {{-- {{ $this->form }} --}}

    @livewire('driver-table')
    {{-- @livewire('user-table') --}}
    @livewire('vehicle-table', ['driver' => $this->model])

</x-filament-panels::page>
