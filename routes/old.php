<?php

use Illuminate\Support\Facades\Route;

// Legacy Student Routes Bridge
Route::prefix('old')->as('old.')->group(function () {
    require __DIR__.'/student_old.php';
});
