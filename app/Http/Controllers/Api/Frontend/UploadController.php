<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UploadController extends Controller
{
//    public $name_file=[];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        foreach ($request->allFiles() as $file){
            $new_name_file=Str::random(40) . '.' . $file->getClientOriginalExtension();
            $result = $file->storeAs('public/files', $new_name_file);
            if ($result){
                $file_what='';
                switch ($file){
                    case $request->file('meliFile'):{
                        $file_what='meliFile';
                        break;
                    }
                    case $request->file('centerFile'):{
                        $file_what='centerFile';
                        break;
                    }
                    case $request->file('expertFile'):{
                        $file_what='expertFile';
                        break;
                    }
                    case $request->file('madrakFile'):{
                        $file_what='madrakFile';
                        break;
                    }
                    case $request->file('profile'):
                        $file_what='profile';
                        break;
                }
                $new_file_data = [
                    'user_id' => $user->id,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'file_name' => $new_name_file,
                    'file_what' => $file_what
                ];
                File::create($new_file_data);
            }else{
                return Response(['message' => trans('api.user.dashboard.error')], 404);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        //
        // $user=Auth::user();
        // Storage::delete('files/'.$id);
        // File::where('file_name',$id)->delete();
        // $new_name_file=Str::random(40) . '.' . $request->file()->getClientOriginalExtension();
        // $result = $request->file()->storeAs('files', $new_name_file);
        // if ($result) {
        //     $file_what='';
        //     switch ($request->file()){
        //         case $request->file('meliFile'):{
        //             $file_what='meliFile';
        //             break;
        //         }
        //         case $request->file('centerFile'):{
        //             $file_what='centerFile';
        //             break;
        //         }
        //         case $request->file('expertFile'):{
        //             $file_what='expertFile';
        //             break;
        //         }
        //         case $request->file('madrakFile'):{
        //             $file_what='madrakFile';
        //             break;
        //         }
        //     }
        //     $new_file_data = [
        //         'user_id' => $user->id,
        //         'file_type' => $request->file()->getMimeType(),
        //         'file_size' => $request->file()->getSize(),
        //         'file_name' => $new_name_file,
        //         'file_what' => $file_what
        //     ];
        //     File::update($new_file_data);
        // }else {
        //     return Response(['message' => trans('api.user.dashboard.error')], 404);
        // }
        // return Response([
        //     'name_files' => $new_name_file,
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function update2($request,$file_name,$file_what)
    {
        $user=Auth::user();
        Storage::delete('public/files/'.$file_name);
        // File::where('file_name',$file_name)->delete();
        $new_name_file=Str::random(40) . '.' . $request->getClientOriginalExtension();
        $result = $request->storeAs('public\files', $new_name_file);
        if ($result) {
            $new_file_data = [
                'file_type' => $request->getMimeType(),
                'file_size' => $request->getSize(),
                'file_name' => $new_name_file,
            ];
            $user->files()->where('file_what',$file_what)->update($new_file_data);
           
        }else {
            return Response(['message' => trans('api.user.dashboard.error')], 404);
        }
    }
}
