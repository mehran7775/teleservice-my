<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DashboardIndexResource;
use App\Models\Address;

use App\Models\File;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function GuzzleHttp\Promise\all;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response(['result' => 'ok']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($request->input('role') == "clerk") {
            $request->validate([
                'meliNumber' => 'required|digits:10',
                'meliFile' => 'required|mimes:jpg,png|max:4048',
                'centerFile' =>'required|file|mimes:pdf',
                'expertFile' =>'nullable',
                'city' => 'required',
                'street' => 'required'
            ]);
            $user->role = $request->input('role');
            $user['number_meli'] = $request->input('meliNumber');
            $user->save();
//            $uploadController=new UploadController;
//            $uploadController->store();
            (new UploadController())->store($request);
            Address::create([
                'user_id' => $user->id,
                'city' => $request->input('city'),
                'street' => $request->input('street')
            ]);
            return Response(
                [
                    'message' => trans('api.user.dashboard.success'),
                    'id' => $user->id,
                ]
                , 202);
        } elseif ($request->input('role') == "expert") {
            $request->validate([
                'meliNumber' => 'require|digits:10',
                'meliFile' => 'require|mimes:jpg,png|max:2048',
                'madrakFile' =>'require|mimes:pdf|max:4048',
                'city' => 'require',
                'street' => 'require'
            ]);
            $user->role = $request->input('role');
            $user['number_meli'] = $request->input('meliNumber');
            $user->save();
            (new UploadController)->store($request);
            Address::create([
                'user_id' => $user->id,
                'city' => $request->input('city'),
                'street' => $request->input('street')
            ]);
            return Response(
                [
                    'message' => trans('api.user.dashboard.success'),
                    'id' => $user->id,
                ]
                , 202);
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
        $user=User::findOrFail($id);
        return Response([
            'user' => new DashboardIndexResource($user)
        ]);
//        'user' => new DashboardIndexResource($user)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user =User::findOrFail($id);
        $data=[
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'number_meli' => $request->input('meliNumber')
        ];
        $user->update($data);
        $user->address->update([
            'city' => $request->input('city'),
            'street' => $request->input('street')
        ]);
        $files=$request->allFiles();
        if ($files){
            foreach ($files as $file){
                switch ($file){
                    case $request->file('meliFile'):{
                        $file_name=$user->files->where('file_what','meliFile')->pluck('file_name')[0];
                        (new UploadController())->update2($file,$file_name,'meliFile');
                        break;
                    }
                    case $request->file('centerFile'):{
                        $file_name=$user->files->where('file_what','centerFile')->pluck('file_name')[0];
                        (new UploadController())->update2($file,$file_name,'centerFile');
                        break;
                    }
                    case $request->file('expertFile'):{
                        $file_name=$user->files->where('file_what','expertFile')->pluck('file_name')[0];
                        (new UploadController())->update2($file,$file_name,'expertFile');
                        break;
                    }
                    case $request->file('madrakFile'):{
                        $file_name=$user->files->where('file_what','madrakFile')->pluck('file_name')[0];
                        (new UploadController())->update2($file,$file_name,'madrakFile');
                        break;
                    }
                }
            }
        }
        return Response([
            'message' => trans('api.user.update.success'),
            'user' => new DashboardIndexResource($user),
        ],201);
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
}
