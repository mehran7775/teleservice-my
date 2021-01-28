<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Category;
use App\Models\Sick;
use App\Http\Requests\api\Cases\CaseRequest;
use App\Http\Requests\api\Cases\CaseUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Resources\Api\CaseResource;
use App\Http\Resources\Api\CaseResourceCollection;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'clerk') {
            $cases = CaseFile::where('user_id', $user->id)->get();
            // return Response($cases);
            if ($cases) {
                return Response(CaseResource::collection($cases));
            } else {
                return Response(['message' => 'هنوز موردی ثبت نشده است.'], 404);
            }
        }else if($user->role=='expert') {
            $cases2=CaseFile::get();
            if ($cases2) {
                // return $cases2;
                return Response(CaseResource::collection($cases2));
            } else {
                return Response(['message' => 'هنوز موردی ثبت نشده است.'], 404);
            }

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store(CaseRequest $request)
    {
        $request->validated();
        $user = auth()->user();
        $category = Category::where('name', $request->input('category'))->first();
        $name_file = Str::random(40) . '.' . $request->file('caseFile')->getClientOriginalExtension();
        $result = $request->file('caseFile')->storeAs('cases', $name_file);
        if ($result) {
            $data_sick = [
                'number_meli' => $request->input('meliNumber'),
                'full_name' => $request->input('fullNameSick')
            ];
            $sick = Sick::updateOrCreate($data_sick);
            $data_case = [
                'user_id' => $user->id,
                'sick_id' => $sick->id,
                'category_id' => $category->id,
                'name' => $name_file,
                'size' => $request->file('caseFile')->getSize(),
                'expired_at' => $request->input('time'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            // $sick->cases->create($data_case);
            $case = CaseFile::create($data_case);
        } else {
            return Response(['message' => trans('api.user.dashboard.error')], 404);
        }

        return Response(
            trans('api.cases.register.success'),
            200
        );
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
     * @return \Illuminate\Http\Response
     */
    public function update(CaseUpdateRequest $request, $id)
    {
        $request->validated();
        $case = CaseFile::findOrFail($id);
        $case->sick->update($request->all(['full_name', 'number_meli']));
        $category = Category::where('name', $request->input('category'))->first();
        $new_data_case = [];
        if ($request->file('caseFile')) {
            unlink(public_path('storage/files/cases'.$case->name));
            $name_file = Str::random(40) . '.' . $request->file('caseFile')->getClientOriginalExtension();
            $result = $request->file('caseFile')->storeAs('public/files', $name_file);
            if ($result) {
                $new_data_case['name'] = $name_file;
                $new_data_case['size'] = $request->file('caseFile')->getSize();
            } else {
                return Response(['message' => 'فایل نامعتبر است'], 404);
            }
        }
        if ($request->input('report')) {
            $new_data_case['report'] = $request->input('report');
        }
        $new_data_case['category_id'] = $category->id;
        $new_data_case['expired_at'] = $request->input('expired_at');
        $new_data_case['updated_at'] = Carbon::now();
        $res = $case->update($new_data_case);
        // $result = $case->update($request->all());
        if ($res) {
            if ($case->report === '0') {
                return Response(
                    [
                        'message' => trans('api.cases.update.success'),
                    ],
                    201
                );
            }else {
                return Response(
                    [
                        'message' => trans('api.cases.register_report'),
                    ],
                    201
                );
            }
           
        } else {
            return Response(trans('api.cases.update.failed'), 400);
        }

        // return Response($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result=CaseFile::findOrFail($id)->delete();
        if ($result) {
            // unlink(public_path('storage/files/cases'.$case->name));
            // Storage::delete('files/cases/' . $case->name);
            return Response([
                'message' =>trans('api.cases.delete.success')
            ],200);
        }else{
            return Response([
                'message' =>trans('api.cases.delete.failed')
            ],202);
        }
        //
    }
}
