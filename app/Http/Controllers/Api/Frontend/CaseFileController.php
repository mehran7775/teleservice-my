<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Models\CaseFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class CaseFileController extends Controller
{
    public function index()
    {

    }
    public function upload(Request $request)
    {
        $this->validate($request, [
            'id_case_radiology' => 'required|unique:case_files,id_case_radiology',
            'fullname_sick' => 'required',
            'code_meli_sick' => 'required|min:9|max:10',
            'fullname_expert' => 'required',
            'code_meli_expert' => 'required|min:9|max:10',
            'fileItem' => 'required'
        ]);
        if (!$caseFile=CaseFile::where('id_radiology', $request->input('id_radiology'))) {
            $user=JWTAuth::user();
            CaseFile::create([
                'id_case_radiology' => $request->input('id_case_radiology'),
//                'user_id' => $caseFile->user()->pluck('id')->first(),
                'fullname_sick' => $request->input('fullname_sick'),
                'code_meli_sick' => $request->input('code_meli_sick'),
                'fullname_expert' => $request->input('fullname_expert'),
                'code_meli_expert' => $request->input('code_meli_expert'),
            ]);
            $new_name_file = Str::random(40) . '.' . $request->file('fileItem')->getClientOriginalExtension();
            $result = $request->file('fileItem')->storeAs('files', $new_name_file);
            if ($result instanceof File) {
                $new_file_data = [
//                    'user_id' =>
                    'file_type' => $request->file('fileItem')->getMimeType(),
                    'file_size' => $request->file('fileItem')->getSize(),
                    'file_name' => $new_name_file
                ];
                $file = File::create($new_file_data);
            }

            return compact(['result' => 'Upload Successfully']);

        }
        return compact(['error' => 'case exist']);
    }
}
