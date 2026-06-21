<x-layouts.admin title="Generate Sertifikat">
    <x-slot name="sidebar">@include('admin.partials.sidebar')</x-slot>
    <livewire:admin.acara.sertifikat-generator :diklat="$diklat" />
</x-layouts.admin>