<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Category;
use App\User;
use App\Models\Sick;
use App\Models\Report;
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
use Illuminate\Support\Facades\DB;

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
        } else if ($user->role == 'expert') {
            $cases2 = CaseFile::get();
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
            $x = $request->input('expired_at');
            $w = explode(':', $request->input('expired_at'));
            if ($w[0] == 00) {
                $w[0] = "24";
            }
            $y = [
                "0" => Carbon::now()->hour,
                "1" => Carbon::now()->minute
            ];
            $z[0] = $w[0] - Carbon::now()->hour;
            $z[1] = $w[1] - Carbon::now()->minute;
            if ($z[1] < 0) {
                $z[0] = $z[0] - 1;
                $z[1] = 60 + $w[1] - $y[1];
            }
            $cost = 50000;
            $n = $z[0];
            switch ($n) {
                case (22 <= $n) && ($n <= 24):
                    $cost = 50000;
                    break;
                case (20 <= $n) && ($n <= 22):
                    $cost = $cost * 10 / 100 + $cost;
                    break;
                case (18 <= $n) && ($n <= 20):
                    $cost = $cost * 20 / 100 + $cost;
                    break;
                case (16 <= $n) && ($n <= 18):
                    $cost = $cost * 30 / 100 + $cost;
                    break;
                case (14 <= $n) && ($n <= 16):
                    $cost = $cost * 40 / 100 + $cost;
                    break;
                case (12 <= $n) && ($n <= 14):
                    $cost = $cost * 50 / 100 + $cost;
                    break;
                case (10 <= $n) && ($n <= 12):
                    $cost = $cost * 60 / 100 + $cost;
                    break;
                case (8 <= $n) && ($n <= 10):
                    $cost = $cost * 70 / 100 + $cost;
                    break;
                case (6 <= $n) && ($n <= 8):
                    $cost = $cost * 80 / 100 + $cost;
                    break;
                case (4 <= $n) && ($n <= 6):
                    $cost = $cost * 90 / 100 + $cost;
                    break;
                case (2 <= $n) && ($n <= 4):
                    $cost = $cost * 100 / 100 + $cost;
                    break;
                case (0 <= $n) && ($n <= 2):
                    $cost = $cost * 110 / 100 + $cost;
                    break;
                default:
                    $cost = 50000;
                    break;
            }
            $data_sick = [
                'number_meli' => $request->input('number_meli'),
                'full_name' => $request->input('full_name')
            ];
            $sick = Sick::updateOrCreate($data_sick);
            $data_case = [
                'user_id' => $user->id,
                'sick_id' => $sick->id,
                'category_id' => $category->id,
                'name' => $name_file,
                'size' => $request->file('caseFile')->getSize(),
                'cost' => $cost,
                'expired_at' => $request->input('expired_at'),
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
            unlink(public_path('storage/files/cases' . $case->name));
            $name_file = Str::random(40) . '.' . $request->file('caseFile')->getClientOriginalExtension();
            $result = $request->file('caseFile')->storeAs('public/files', $name_file);
            if ($result) {
                $new_data_case['name'] = $name_file;
                $new_data_case['size'] = $request->file('caseFile')->getSize();
            } else {
                return Response(['message' => 'فایل نامعتبر است'], 404);
            }
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
            } else {
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
        $sick_id=CaseFile::findOrFail($id)->sick_id;
        $result = CaseFile::findOrFail($id)->delete();
        if ($result) {
            Sick::findOrFail($sick_id)->delete();
            // unlink(public_path('storage/files/cases'.$case->name));
            // Storage::delete('files/cases/' . $case->name);
            return Response([
                'message' => trans('api.cases.delete.success')
            ], 200);
        } else {
            return Response([
                'message' => trans('api.cases.delete.failed')
            ], 202);
        }
        //
    }
    public function verify_report(Request $request){
        $this->validate($request,[
            'id' => 'required|integer'
        ]);
        $case=CaseFile::where('id',$request->input('id'))->first();
        if ($case) {
            $case->status=1;
            $case->save();
            $report=$case->report()->first();
            $user_id=$report->user_id;
            // $user=User::findOrFail($user_id);
          
            if($wallet=DB::table('wallets')->where('user_id',$user_id)->first()){
                $amount=$wallet->amount;
                $amount=$amount+$case->cost;
                DB::table('wallets')->where('user_id',$user_id)->update([
                    'amount' => $amount
                ]);
            }else{
                DB::table('wallets')->insert([
                    'amount' => $case->cost,
                    'user_id' => $user_id
                ]);
            }
            return Response([
                'message' => trans('api.cases.verify_report.success')
            ],200);
        }else{
            return Response([
                'message' => trans('api.cases.verify_report.failed')
            ],404);
        }
    }
    public function dont_verify_report(Request $request){
        $this->validate($request,[
            'id' => 'required|integer'
        ]);
        $case=CaseFile::findOrFail($request->input('id'));
        $res=$case->report->delete();
        if ($res==1) {
            return Response([
                'message' => trans('api.cases.dont_verify_report.success')
            ],200);
        }else {
            return Response([
                'message' => trans('api.cases.dont_verify_report.failed')
            ],406);
        }
       
    }
}
