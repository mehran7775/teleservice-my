<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Category;
use App\Models\Sick;
use App\Http\Requests\api\Cases\CaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Resources\Api\CaseResource;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $cases=CaseFile::where('user_id',$user->id)->get();
        // return Response($cases);
        if($cases){
            return Response(CaseResource::collection($cases));
        }else{
            return Response(['message' => 'هنوز موردی ثبت نشده است.'],404);
        }
        // $case=CaseFile::find(11);
        // return Response($case->sick->pluck('number_meli')[0]);
        // return Response($case->category);
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
        $user=auth()->user();
        $category=Category::where('name',$request->input('category'))->first();
        $name_file=Str::random(40).'.'.$request->file('caseFile')->getClientOriginalExtension();
        $result=$request->file('caseFile')->storeAs('files',$name_file);
        if($result){
            $data_sick=[
                'number_meli' =>$request->input('meliNumber'),
                'full_name' => $request->input('fullNameSick')
            ];
            $sick=Sick::updateOrCreate($data_sick);
            $data_case=[
                'user_id' =>$user->id,
                'sick_id' =>$sick->id,
                'category_id' =>$category->id,
                'name' => $name_file,
                'size' => $request->file('caseFile')->getSize(),
                'expired_at' => $request->input('time'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            // $sick->cases->create($data_case);
            $case=CaseFile::create($data_case);


        }else{
            return Response(['message' => trans('api.user.dashboard.error')], 404);
        }

       return Response('ثبت باموفقیت انجام شد'
    ,201);


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
    public function update(Request $request, $id)
    {
        //
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
