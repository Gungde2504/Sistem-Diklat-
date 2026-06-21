<x-layouts.admin title="Tampil QR Absensi">

    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>

    <livewire:admin.absensi.tampil-qr :diklat="$diklat" />

</x-layouts.admin>