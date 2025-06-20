<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Azkar;
use App\Models\AzkarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AzkarController extends Controller
{
    protected $updateAzkar =['azkar_ar','azkar_en','status','note'];

    public function getAzkar(){
        $azkar = Azkar::all();
        $data =[
            'azkar'=>$azkar
        ];
        return response()->json($data);
    }

    public function addAzkar(Request $request){
        $validation = Validator::make($request->all(),[
            'category_id' => 'required|integer|exists:azkar_categories,id',
            'azkar_ar' => 'required|string',
            'azkar_en' => 'required|string',
            'status' => 'required|integer|in:0,1',
            'note'=>'nullable|string',
            'azkar_count'=>'nullable|integer',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $azkar = Azkar::create([
            'azkar_ar' => $request->azkar_ar,
            'azkar_en' => $request->azkar_en,
            'status' => (string)$request->status,
            'note' => $request->note,
            'category_id' => $request->category_id,
            'azkar_count'=>$request->azkar_count,
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
            'azkar_ar' => 'nullable|string',
            'azkar_en' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
            'note'=>'nullable|string',
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

    public function deleteCategory($id)
    {
        $category = AzkarCategory::find($id);
        $category->delete();
        $data = [
            'message' => 'Category Deleted Successfully',
        ];
        return response()->json($data);
    }

    public function getAzkarCategory($category_id){
        $azkar = Azkar::where('category_id', $category_id)->get();
        $data =[
            'azkar'=>$azkar
        ];
        return response()->json($data);
    }

    public function getAzkarCategories(){
        $azkar = AzkarCategory::all();
        $data =[
            'azkar_Categories'=>$azkar
        ];
        return response()->json($data);
    }

    public function addAzkarCategory(Request $request){
        $validation = Validator::make($request->all(),[
            'category_name' => 'required|string|unique:azkar_categories',
            'category_name_ar'=>'required|string|unique:azkar_categories'
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $azkar = AzkarCategory::create([
            'category_name' => $request->category_name,
            'category_name_ar'=>$request->category_name_ar
        ]);

        $data = [
            'message' => 'Azkar Category Added Successfully',
        ];

        return response()->json($data);
    }
}
