<?php

namespace ikepu_tp\ActivityLog\app\Http\Middleware;

use Closure;
use ikepu_tp\ActivityLog\app\Models\Activity_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogMiddleware
{
    protected $route_name;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $next;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->request = $request;
        $this->next = $next;
        $this->route_name = Route::currentRouteName();
        $activities = config("activity-log.activities", []);

        //ルート名
        if (isset($activities[$this->route_name])) return $this->log($this->getActivity($activities[$this->route_name]));
        //入れ子ルート名
        $ireko_activities = $activities;
        $ireko = true;
        foreach (explode(".", $this->route_name) as $route_name) {
            if (!isset($ireko_activities[$route_name])) {
                $ireko = false;
                break;
            }
            $ireko_activities = $ireko_activities[$route_name];
        }
        if ($ireko) return $this->log($this->getActivity($ireko_activities));
        //登録なし
        if (config("activity-log.all_activities")) return $this->log($this->getActivity([]));

        return $next($request);
    }

    public function log(array $activity): Response
    {
        $log = new Activity_log([
            "user_id" => $this->request->user($activity["guard"])->getKey(),
            "guard" => $activity["guard"],
            "route_name" => $this->route_name,
            "path" => $activity["path"],
            "activity" => $activity["activity"],
        ]);
        $log->save();
        $next = $this->next;
        return $next($this->request);
    }

    public function getActivity(string|array $activity): array
    {
        $activities = [
            "path" => $this->request->path(),
            "activity" => config("activity-log.activity_text", ":pathで:activityをしました"),
            "guard" => config("activity-log.guard"),
        ];

        // 結合
        if (is_string($activity)) {
            $activities["activity"] = $activity;
        } else {
            $activities = array_merge($activities, $activity);
        }

        // 置換
        $activities["activity"] = str_replace([
            ":path", ":activity"
        ], [
            $this->request->path(), $activities["activity"]
        ], $activities["activity"]);

        return $activities;
    }
}