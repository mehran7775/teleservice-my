<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'profile' => 'required|image|mimes:jpeg|max:2500000'
        ]);
        $user = Auth::user();
        if ($user) {
            (new UploadController)->store($request);
            $name_profile = $user->files->where('file_what', 'profile')->pluck('file_name')[0];
            return Response([
                'message' => trans('api.user.profile.store.success'),
                'name_profile' => $name_profile
            ], 201);
            // $storagePath."files\\"

        } else {
            return response()->json(['message' => 'کاربر نامعتبر میباشد'], 404);
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
        $path = asset('storage/files/' . $id);
        if ($path) {
            return Response([
                'avatar' => $path
            ], 200);
        } else {
            return Response([
                'message' => trans('api.user.profile.show.failed')
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'profile' => 'required|image|mimes:jpeg|max:2500000'
        ]);
        // $user = Auth::user();
        Storage::delete('public/files/' . $id);
        $new_name_file = Str::random(40) . '.' . $request->file('profile')->getClientOriginalExtension();
        $result = $request->file('profile')->storeAs('public/files', $new_name_file);
        if ($result) {
            $new_file_data = [
                'file_type' => $request->file('profile')->getMimeType(),
                'file_size' => $request->file('profile')->getSize(),
                'file_name' => $new_name_file,
            ];
            File::where('file_name',$id)->update($new_file_data);
            return Response([
                'name_profile' => $new_name_file
            ], 201);
        } else {
            return Response([
                'message' => 'خطایی در ذخیره سازی پروفایل رخ داده است.'
            ]);
        }
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
