<?php

namespace ikepu_tp\ActivityLog\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ActivityLog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command adds Activity Log to project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->updateFile(base_path("routes/web.php"), 'Route::get("activity-log", [ActivityLogController::class, "index"])->middleware(["auth:" . config("activity-log.guard")])->name("activity-log.index");');
    }

    protected function updateFile(string $path, string $code): void
    {
        if (!file_exists($path)) {
            return;
        }

        $file = file_get_contents($path);

        file_put_contents(
            $path,
            $file . PHP_EOL  . PHP_EOL . $code . PHP_EOL
        );

        $this->info("Update \"{$path}\".");
    }
}
