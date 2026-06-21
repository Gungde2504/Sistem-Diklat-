<x-layouts.admin title="Detail Acara">

    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    <livewire:admin.acara.acara-detail :diklat="$diklat" />

</x-layouts.admin>