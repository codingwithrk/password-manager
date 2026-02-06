<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::lock-screen')->name('lock-screen');
Route::livewire('/home', 'pages::home-screen')->name('home-screen');
Route::livewire('/add-new-password', 'pages::add-new-password-screen')->name('add-new-password');
Route::livewire('/info', 'pages::info-screen')->name('info-screen');
