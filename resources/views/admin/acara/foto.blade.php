<x-layouts.admin title="Foto Dokumentasi">

    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    <livewire:admin.acara.foto-dokumentasi :diklat="$diklat" />

</x-layouts.admin>