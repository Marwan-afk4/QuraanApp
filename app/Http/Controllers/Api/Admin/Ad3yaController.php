<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad3ya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Ad3yaController extends Controller
{

    protected $updateAd3ya =['ad3ya_ar','ad3ya_en','status','note'];

    public function getAd3ya(){
        $ad3ya = Ad3ya::all();
        $data =[
            'ad3ya'=>$ad3ya
        ];
        return response()->json($data);
    }

    public function addAd3ya(Request $request){
        $validation = Validator::make($request->all(),[
            'ad3ya_ar' => 'required|string',
            'ad3ya_en' => 'required|string',
            'status' => 'required|between:0,1',
            'note'=>'nullable|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $ad3ya = Ad3ya::create([
            'ad3ya_ar' => $request->ad3ya_ar,
            'ad3ya_en' => $request->ad3ya_en,
            'status' => (string)$request->status,
            'note' => $request->note
        ]);

        $data = [
            'message' => 'Ad3ya Added Successfully',
            'ad3ya' => $ad3ya
        ];

        return response()->json($data);
    }

    public function deleteAd3ya($id){
        $ad3ya = Ad3ya::find($id);
        $ad3ya->delete();
        $data = [
            'message' => 'Ad3ya Deleted Successfully',
        ];
        return response()->json($data);
    }

    public function UpdateAd3ya(Request $request, $id){
        $ad3ya = Ad3ya::find($id);
        $validation = Validator::make($request->all(),[
            'ad3ya_ar' => 'nullable|string',
            'ad3ya_en' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
            'note'=>'nullable|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }
        $updateAd3ya = $request->only($this->updateAd3ya);
        $ad3ya->update($updateAd3ya);
        $data = [
            'message' => 'Ad3ya Updated Successfully',
            'ad3ya' => $ad3ya
        ];
        return response()->json($data);
    }
}
