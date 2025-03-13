<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Azkar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AzkarController extends Controller
{
    protected $updateAzkar =['azkar_ar','azkar_en','status'];

    public function getAzkar(){
        $azkar = Azkar::all();
        $data =[
            'azkar'=>$azkar
        ];
        return response()->json($data);
    }

    public function addAzkar(Request $request){
        $validation = Validator::make($request->all(),[
            'azkar-ar' => 'required|string',
            'azkar-en' => 'required|string',
            'status' => 'required|integer|in:0,1',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $azkar = Azkar::create([
            'azkar_ar' => $request->azkar_ar,
            'azkar_en' => $request->azkar_en,
            'status' => $request->status,
        ]);

        $data = [
            'message' => 'Azkar Added Successfully',
            'azkar' => $azkar
        ];

        return response()->json($data);
    }

    public function UpdateAzkar(Request $request, $id){
        $azkar = Azkar::find($id);
        $validation = Validator::make($request->all(),[
            'azkar-ar' => 'sometimes|string',
            'azkar-en' => 'sometimes|string',
            'status' => 'sometimes|integer|in:0,1',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }
        $updateAzkar = $request->only($this->updateAzkar);
        $azkar->update($updateAzkar);
        $data = [
            'message' => 'Azkar Updated Successfully',
            'azkar' => $azkar
        ];
        return response()->json($data);

    }

    public function deleteAzkar($id){
        $azkar = Azkar::find($id);
        $azkar->delete();
        $data = [
            'message' => 'Azkar Deleted Successfully',
        ];
        return response()->json($data);
    }
}
