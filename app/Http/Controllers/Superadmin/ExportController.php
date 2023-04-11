<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    //
    public function index()
    {
        return view('superadmin.export.index');
    }

    public function export_db()
    {
        // Will change to spatie later
        $path = base_path('backups');
        // Make a folder named backups if it doesn't exist
        if (!is_dir($path)) {
            mkdir($path);
        }
        // Set the database name and path where the backup file will be stored
        // $dbname = env('DB_NAME');
        $dbname = 'codeworm';

        $backupPath = $path . "/{$dbname}-" . date('YmdHis') . '.sql';

        // Use the mysqldump command to create the backup file
        // $command = 'mysqldump --user=' . env('DB_USERNAME') . ' --password=' . env('DB_PASSWORD') . ' --host=' . env('DB_HOST') . " {$dbname} > {$backupPath}";

        $command = 'mysqldump --user=' . 'root' . ' --password=' . '' . ' --host=' . 'localhost' . " {$dbname} > {$backupPath}";

        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        // Download the backup file
        return response()
            ->download($backupPath)
            ->deleteFileAfterSend();
    }
}
