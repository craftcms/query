<?php

declare(strict_types=1);

use CraftCms\Query\Http\Controllers\ExecuteQueryController;
use Illuminate\Support\Facades\Route;

Route::post('utilities/query', ExecuteQueryController::class)
    ->middleware('can:utility:query');
