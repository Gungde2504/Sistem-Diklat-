<x-layouts.admin title="Manajemen Acara">

    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    <livewire:admin.acara.acara-index />

</x-layouts.admin>