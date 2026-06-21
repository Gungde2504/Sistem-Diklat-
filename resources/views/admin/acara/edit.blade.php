<x-layouts.admin title="Edit Acara">

    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    <livewire:admin.acara.acara-edit :diklat="$diklat" />

</x-layouts.admin>