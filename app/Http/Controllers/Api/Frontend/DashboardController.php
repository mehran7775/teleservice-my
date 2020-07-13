<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;

use App\Http\Resources\Api\DashboardIndexResource;
use App\Models\Address;
use App\Models\File;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user()->get();
            return response()->json(['success' => DashboardIndexResource::collection($user)], 200);
        } else {
            return response()->json(['message' => 'Unauthenticated']);
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'number_meli' => 'required|int|digits:10',
            'copy_card_meli' => 'required',
            'file_license_establish_radiology_center' => 'required|filled',
            'file_degree_specialist_radiology' =>'nullable|filled',
            'city' => 'required|string|min:4',
            'street' => 'required|string'
        ]);
        $user = Auth::user();
        $new_file_name = Str::random(40) . '.' . $request->file('file_license_establish_radiology_center')->getClientOriginalExtension();
        $result = $request->file('file_license_establish_radiology_center')->storeAs('files', $new_file_name);
        if ($result instanceof \Symfony\Component\HttpFoundation\File\File) {
            $new_file_data = [
                'user_id' => $user->id,
                'file_type' => $request->file('file_license_establish_radiology_center')->getMimeType(),
                'file_size' => $request->file('file_license_establish_radiology_center')->getSize(),
                'file_name' => $new_file_name
            ];
            File::create($new_file_data);
        }else{
            return response()->json(['message' =>trans('api.user.dashboard.error')]);
        }
        if (is_uploaded_file('file_degree_specialist_radiology')) {
            $new_file_name = Str::random(40) . '.' . $request->file('file_degree_specialist_radiology')->getClientOriginalExtension();
            $result = $request->file('file_degree_specialist_radiology')->storeAs('files', $new_file_name);
            if ($result instanceof \Symfony\Component\HttpFoundation\File\File) {
                $new_file_data = [
                    'user_id' => $user->id,
                    'file_type' => $request->file('file_degree_specialist_radiology')->getMimeType(),
                    'file_size' => $request->file('file_degree_specialist_radiology')->getSize(),
                    'file_name' => $new_file_name
                ];
                File::create($new_file_data);
            }
            return response()->json(['message' =>trans('api.user.dashboard.error')]);
        }
        Address::create([
            'user_id' => $user->id,
            'city' => $request->input('city'),
            'street' => $request->input('street')
        ]);
        return response()->json(['message' => trans('api.user.dashboard.success')]);
    }
}
