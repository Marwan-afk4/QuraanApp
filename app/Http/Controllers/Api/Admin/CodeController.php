<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{


    public function getCode(){
        $code = Code::all();
        $data =[
            'codes' => $code
        ];
        return response()->json($data);
    }

    public function addCode(Request $request){
        $validation = Validator::make($request->all(),[
            'code'=>'required',
            'interstitial'=>'required|between:0,1',
            'banner' => 'required|between:0,1'
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $code = Code::create([
            'code'=>$request->code,
            'interstitial' =>$request->interstitial,
            'banner'=>$request->banner
        ]);
        return response()->json(['message'=>'code added sucessffully']);
    }

    public function deleteCode($id){
        $Code = Code::findOrFail($id);
        $Code->delete();
        $data = [
            'message' => 'Azkar Deleted Successfully',
        ];
        return response()->json($data);
    }

}
