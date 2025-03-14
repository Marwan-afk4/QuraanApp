<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ahadeth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AhadethController extends Controller
{

    protected $updateAhadeth =['ahadeth_ar','ahadeth_en','status','note'];

    public function getAhadeth(){
        $ahadeth = Ahadeth::all();
        $data =[
            'ahadeth'=>$ahadeth
        ];
        return response()->json($data);
    }

    public function addAhadeth(Request $request){
        $validation = Validator::make($request->all(),[
            'ahadeth_ar' => 'required|string',
            'ahadeth_en' => 'required|string',
            'status' => 'required|integer|in:0,1',
            'note'=>'sometimes|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $ahadeth = Ahadeth::create([
            'ahadeth_ar' => $request->ahadeth_ar,
            'ahadeth_en' => $request->ahadeth_en,
            'status' => (string)$request->status,
            'note' => $request->note
        ]);

        $data = [
            'message' => 'Ahadeth Added Successfully',
            'ahadeth' => $ahadeth
        ];

        return response()->json($data);
    }


    public function deleteAhadeth($id){
        $ahadeth = Ahadeth::find($id);
        $ahadeth->delete();
        $data = [
            'message' => 'Ahadeth Deleted Successfully',
        ];
        return response()->json($data);
    }

    public function UpdateAhadeth(Request $request, $id){
        $ahadeth = Ahadeth::find($id);
        $validation = Validator::make($request->all(),[
            'ahadeth_ar' => 'sometimes|string',
            'ahadeth_en' => 'sometimes|string',
            'status' => 'sometimes|integer|in:0,1',
            'note'=>'sometimes|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }
        $updateAhadeth = $request->only($this->updateAhadeth);
        $ahadeth->update($updateAhadeth);
        $data = [
            'message' => 'Ahadeth Updated Successfully',
            'ahadeth' => $ahadeth
        ];
        return response()->json($data);

    }

}
