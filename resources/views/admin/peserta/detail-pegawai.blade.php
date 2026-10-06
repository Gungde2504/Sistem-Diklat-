<x-layouts.admin title="Detail Pegawai">
    <x-slot name="sidebar">@include('admin.partials.sidebar')</x-slot>
    <livewire:admin.peserta.peserta-detail-pegawai :pegawai="$pegawai" />
</x-layouts.admin>
