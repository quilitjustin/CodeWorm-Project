<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;

class ExportController extends Controller
{
    //
    public function index()
    {
        return view('admin.export.index');
    }

    public function export_db()
    {
        // Set the file name for the backup file
        $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.sql';

        // Generate the backup file and store it in the storage/app directory
        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile(storage_path('app/' . $fileName));

        // Return the backup file to the user
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Transfer-Encoding' => 'binary',
        ];
        
        return response()
            ->download(storage_path('app/' . $fileName), $fileName, $headers)
            ->deleteFileAfterSend();
    }
}
