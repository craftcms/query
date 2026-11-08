<?php

declare(strict_types=1);

use CraftCms\Query\Http\Controllers\ExecuteQueryController;
use Illuminate\Support\Facades\Route;

// Keeps the Craft 5 action path (`query/default/execute`) working.
// It’s reachable at site action URLs too, so it requires a login.
Route::post('default/execute', ExecuteQueryController::class)
    ->middleware(['auth', 'can:utility:query']);
