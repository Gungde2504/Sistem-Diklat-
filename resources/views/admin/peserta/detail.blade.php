<x-layouts.admin title="Detail Peserta">
    <x-slot name="sidebar">@include('admin.partials.sidebar')</x-slot>
    <livewire:admin.peserta.peserta-detail :detail="$detail" />
</x-layouts.admin>