<x-layouts.admin title="Detail Modul E-Learning">
    <x-slot name="sidebar">
        @include('admin.partials.sidebar')
    </x-slot>
    <livewire:admin.e-learning.modul-show :modul="$modul" />
</x-layouts.admin>