<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseFile;

class DownloadController extends Controller
{
    public function download($name){
        $path=asset('storage/files/cases/'.$name);
        $newName = 'file-'.time().'.pdf';
        $header = [
            'Content-Type' => 'application/*',
        ];
        return response()->download($path,$newName,$header);
    }
}
