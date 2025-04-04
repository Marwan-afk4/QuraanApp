<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AyatController extends Controller
{
    protected $updateAyat=['ayat_ar','ayat_en','status','note'];

    public function getAyat(){
        $ayat = Ayat::all();
        $data =[
            'ayat'=>$ayat
        ];
        return response()->json($data);
    }

    public function addAyat(Request $request){
        $validation = Validator::make($request->all(),[
            'ayat_ar' => 'required|string',
            'ayat_en' => 'required|string',
            'status' => 'required|integer|in:0,1',
            'note'=>'nullable|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()],400);
        }

        $ayat = Ayat::create([
            'ayat_ar' => $request->ayat_ar,
            'ayat_en' => $request->ayat_en,
            'status' => (string)$request->status,
            'note' => $request->note
        ]);

        $data = [
            'message' => 'Ayat Added Successfully',
            'ayat' => $ayat
        ];

        return response()->json($data);
    }

    public function UpdateAyat(Request $request, $id){
        $ayat = Ayat::find($id);
        $validation = Validator::make($request->all(),[
            'ayat_ar' => 'sometimes|string',
            'ayat_en' => 'sometimes|string',
            'status' => 'sometimes|integer|in:0,1',
            'note'=>'sometimes|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }
        $updateAyat = $request->only($this->updateAyat);
        $ayat->update($updateAyat);
        $data = [
            'message' => 'Ayat Updated Successfully',
            'ayat' => $ayat
        ];
        return response()->json($data);
    }

    public function deleteAyat($id){
        $ayat = Ayat::find($id);
        $ayat->delete();
        $data = [
            'message' => 'Ayat Deleted Successfully',
        ];
        return response()->json($data);
    }
}
