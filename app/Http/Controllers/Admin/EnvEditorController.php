<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnvEditorController extends Controller
{
    public function code_executor()
    {
        return view('admin.env_editor.code_executor');
    }

    public function update_code_executor(Request $request)
    {
        $request->validate([
            'url' => ['required'],
        ]);
        $key = 'APP_CODE_EXECUTOR';
        $value = $request['url'];
    
        // Update the environment variable and write to the .env file
        $envFilePath = app()->environmentFilePath();
        if (file_exists($envFilePath)) {
            $envContent = file_get_contents($envFilePath);
            $envContent = preg_replace("/^$key=.*/m", "$key=$value", $envContent);
            file_put_contents($envFilePath, $envContent);
        }
    
        // Reload the environment variables
        $this->reload_env();
    
        // Redirect back with a success message
        return back()->with('msg', "Updated successfully.");
    }


    protected function reload_env()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(base_path());
        $dotenv->load();
    }
}
