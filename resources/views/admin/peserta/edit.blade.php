<x-layouts.admin title="Edit Peserta Eksternal">
    <x-slot name="sidebar">@include('admin.partials.sidebar')</x-slot>
    <livewire:admin.peserta.peserta-edit :detail="$detail" />
</x-layouts.admin>