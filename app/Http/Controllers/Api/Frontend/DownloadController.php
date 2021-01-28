<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseFile;
use Illuminate\Support\Facades\URL;

class DownloadController extends Controller
{
    public function download($name){
        $newName = 'file-case.pdf';
        $header = [
            'Content-Type' => 'application/pdf',
        ];
        return response()->download(public_path()."/storage/files/cases/".$name,$newName,$header);     
    }
}
