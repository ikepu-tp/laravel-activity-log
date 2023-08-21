<?php

use ikepu_tp\ActivityLog\app\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => "auth:" . config("activity-log.guard"),
], function () {
    Route::get("activity-log", [ActivityLogController::class, "index"])->name("activity-log.index");
});