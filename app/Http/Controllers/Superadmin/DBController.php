<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\DbDumper;
use Spatie\DbDumper\Importers\DbImporter;
use Illuminate\Support\Facades\Schema;
use DB;

class DBController extends Controller
{
    //
    public function index()
    {
        return view('superadmin.db.index');
    }

    public function export()
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

    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|mimetypes:text/plain,application/octet-stream,application/x-sql',
        ]);

        $file = $request->file('sql_file');

        // Create a new MySql instance
        $mysql = MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->setHost(env('DB_HOST'))
            ->setPort(env('DB_PORT'));

        // Import the dump file
        $importer = new DbImporter($mysql);
        $importer->importFromFile($file);

        unlink($file->getRealPath()); // Delete the uploaded file

        // Return a success message
        $message = 'SQL file uploaded successfully. Imported ' . count($tablesToImport) . ' tables.';

        return redirect()
            ->back()
            ->with('msg', $message);
    }
}
