<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
class RouteNameToPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:send-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all route names with web middleware to the main website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Mendapatkan semua route yang terdaftar
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            // Memeriksa apakah route memiliki nama dan menggunakan middleware web
            if ($route->getName() != '' && $route->getAction()['middleware']['0'] == 'web') {
                // Mengirim data route ke API di website utama
                $response = Http::post(env('API_BASE_URL') . '/api/store-route', [
                    'name' => $route->getName(),
                ]);

                if ($response->successful()) {
                    $this->info("Route {$route->getName()} sent successfully to main website.");
                } else {
                    $this->error("Failed to send route {$route->getName()} to main website.");
                }
            }
        }

        $this->info('All routes have been processed.');
    }
}
