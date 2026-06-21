<x-layouts.admin title="Edit Modul E-Learning">
    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>
    <livewire:admin.e-learning.modul-edit :modul="$modul" />
</x-layouts.admin>