<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('image', function () {
            return new ImageManager(new Driver());
        });

        $this->app->bind(ImageManager::class, function () {
            return new ImageManager(new Driver());
        });
    }

    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');
        date_default_timezone_set(config('app.timezone'));

        View::composer('*', function ($view) {
            $view->with('authUser', Auth::user());
        });

        // Register Livewire components manually
        \Livewire\Livewire::component('admin.e-learning.modul-index', \App\Livewire\Admin\Elearning\ModulIndex::class);
        \Livewire\Livewire::component('admin.e-learning.modul-create', \App\Livewire\Admin\Elearning\ModulCreate::class);
        \Livewire\Livewire::component('admin.e-learning.modul-edit', \App\Livewire\Admin\Elearning\ModulEdit::class);
        \Livewire\Livewire::component('admin.e-learning.modul-show', \App\Livewire\Admin\Elearning\ModulShow::class);
        \Livewire\Livewire::component('pegawai.e-learning.elearning-index', \App\Livewire\Pegawai\Elearning\ElearningIndex::class);
        \Livewire\Livewire::component('pegawai.e-learning.elearning-detail', \App\Livewire\Pegawai\Elearning\ElearningDetail::class);
    }

    public static function redirectByRole($user)
    {
        return match ($user->role) {
            'super_admin'       => '/admin/dashboard',
            'admin_diklat'      => '/admin/dashboard',
            'pegawai'           => '/pegawai/dashboard',
            'peserta_eksternal' => '/eksternal/dashboard',
            default             => '/',
        };
    }
}