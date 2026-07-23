<?php

use Illuminate\Support\Facades\Route;

Route::get('settings', function () {
    return view('settings.index');
})->name('settings.index');
Route::get('habits', function () {
    return view('habits.index');
})->name('habits.index');
Route::get('tasks', function () {
    return view('tasks.index');
})->name('tasks.index');

Route::get('logout', function () {
    return view('habits.index');
})->name('logout');