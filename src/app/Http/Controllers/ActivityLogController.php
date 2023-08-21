<?php

namespace ikepu_tp\ActivityLog\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use ikepu_tp\ActivityLog\app\Http\Requests\StoreRequest;
use ikepu_tp\ActivityLog\app\Http\Requests\UpdateRequest;
use ikepu_tp\ActivityLog\app\Models\Activity_log;

class ActivityLogController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view("ActivityLog::activity-log.index", [
            "logs" => Activity_log::where('user_id', $request->user(config("activity-log.guard"))->getKey())->orderBy("created_at", "DESC")->paginate($request->query("per", 10))->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $storeRequest)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $updateRequest, string $user_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}