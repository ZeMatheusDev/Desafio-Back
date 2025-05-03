<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProtectedDownloads extends Controller
{
    public function visualizar($path)
    {
        try {
            $originalPath = str_replace('-', '/', $path);
            
            $file = Storage::disk('public')->get($originalPath);
            
            return response($file)
                ->header('Content-Type', Storage::mimeType($originalPath))
                ->header('Content-Disposition', 'inline');
    
        } catch (\Exception $e) {
            abort(404, 'Arquivo não encontrado');
        }
    }
}
