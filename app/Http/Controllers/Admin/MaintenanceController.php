<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InfoPsbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MaintenanceController extends Controller
{
    private InfoPsbService $infoPsbService;

    public function __construct(InfoPsbService $infoPsbService)
    {
        $this->infoPsbService = $infoPsbService;
    }

    public function migrate(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('migrate', ['--force' => true]);
        return $this->jsonResponse(Artisan::output());
    }

    public function migrateRefresh(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('migrate:refresh', ['--force' => true]);
        return $this->jsonResponse(Artisan::output());
    }

    public function clearAll(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize');
        return $this->jsonResponse(Artisan::output());
    }

    public function clearCache(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('cache:clear');
        return $this->jsonResponse(Artisan::output());
    }

    public function clearView(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('view:clear');
        return $this->jsonResponse(Artisan::output());
    }

    public function clearRoute(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('route:clear');
        return $this->jsonResponse(Artisan::output());
    }

    public function clearConfig(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('config:clear');
        return $this->jsonResponse(Artisan::output());
    }

    public function optimize(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('optimize');
        return $this->jsonResponse(Artisan::output());
    }

    public function queueRestart(): \Illuminate\Http\JsonResponse
    {
        Artisan::call('queue:restart');
        return $this->jsonResponse(Artisan::output());
    }

    public function dbBackup(): BinaryFileResponse|\Illuminate\Http\JsonResponse
    {
        $filename = 'backup_' . date('Y-m-d_His') . '.sql';
        $backupDir = storage_path('app/backups');

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $path = $backupDir . '/' . $filename;

        $dbHost = config('database.connections.mysql.host');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbName = config('database.connections.mysql.database');

        exec("mysqldump -h$dbHost -u$dbUser -p$dbPass $dbName > $path 2>&1", $output, $return);

        if ($return !== 0) {
            return response()->json(['success' => false, 'message' => 'Backup failed: ' . implode("\n", $output)], 500);
        }

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    public function info(): \Illuminate\Http\JsonResponse
    {
        $routeList = [];
        $routes = app()->getRoutes();
        foreach ($routes->getRoutes() as $route) {
            $routeList[] = [
                'methods' => $route->methods(),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        }

        return response()->json([
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'db_connection' => config('database.default'),
            'db_database' => config('database.connections.mysql.database'),
            'server_os' => PHP_OS,
            'max_execution_time' => ini_get('max_execution_time'),
            'post_max_size' => ini_get('post_max_size'),
            'memory_limit' => ini_get('memory_limit'),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug'),
            'env' => config('app.env'),
            'total_routes' => count($routeList),
        ]);
    }

    private function jsonResponse(string $output): \Illuminate\Http\JsonResponse
    {
        $lines = array_filter(array_map('trim', explode("\n", $output)));
        return response()->json([
            'success' => true,
            'output' => $lines,
        ]);
    }
}
