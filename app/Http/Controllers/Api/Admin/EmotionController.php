<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emotion;
use App\Models\EmotionAll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmotionController extends Controller
{
    protected $updateEmotionAll =['emotion_id','ayat_id','ad3ya_id','ahadeth_id','azkar_id'];

    public function getEmotion(){
        $emotion = Emotion::all();
        $data =[
            'emotion' => $emotion
        ];
        return response()->json($data);
    }

    public function deleteEmotion($id){
        $emotion = Emotion::find($id);
        $emotion->delete();
        $data = [
            'message' => 'Emotion Deleted Successfully',
        ];
        return response()->json($data);
    }

    public function addEmotion(Request $request){
        $validation = Validator::make($request->all(),[
            'emotion_name' => 'required|string',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $emotion = Emotion::create([
            'emotion_name' => $request->emotion_name
        ]);

        $data = [
            'message' => 'Emotion Added Successfully',
            'emotion' => $emotion
        ];

        return response()->json($data);
    }

//Add things to emotions

    public function addtoEmotions(Request $request){
        $validation = Validator::make($request->all(),[
            'emotion_id' => 'required|integer|exists:emotions,id',
            'ayat_id' => 'nullable|integer|exists:ayats,id',
            'ad3ya_id' => 'nullable|integer|exists:ad3yas,id',
            'ahadeth_id' => 'nullable|integer|exists:ahadeths,id',
            'azkar_id' => 'nullable|integer|exists:azkars,id',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }

        $emotion = EmotionAll::create([
            'emotion_id' => $request->emotion_id,
            'ayat_id' => $request->ayat_id ?? null,
            'ad3ya_id' => $request->ad3ya_id ?? null,
            'ahadeth_id' => $request->ahadeth_id ?? null,
            'azkar_id' => $request->azkar_id ?? null
        ]);

        $data = [
            'message' => 'Emotion Added Successfully',
            'emotion' => $emotion
        ];

        return response()->json($data);
    }

    public function deletEmotionAll($id){
        $emotion = EmotionAll::find($id);
        $emotion->delete();
        $data = [
            'message' => 'Emotion Deleted Successfully',
        ];
        return response()->json($data);
    }

    public function updateEmotionAll(Request $request, $id){
        $emotion = EmotionAll::find($id);
        $validation = Validator::make($request->all(),[
            'emotion_id' => 'sometimes|integer|exists:emotions,id',
            'ayat_id' => 'sometimes|integer|exists:ayats,id',
            'ad3ya_id' => 'sometimes|integer|exists:ad3yas,id',
            'ahadeth_id' => 'sometimes|integer|exists:ahadeths,id',
            'azkar_id' => 'sometimes|integer|exists:azkars,id',
        ]);
        if($validation->fails()){
            return response()->json(['errors'=>$validation->errors()]);
        }
        $updateEmotionAll = $request->only($this->updateEmotionAll);
        $emotion->update($updateEmotionAll);
        $data = [
            'message' => 'Emotion Updated Successfully',
            'emotion' => $emotion
        ];
        return response()->json($data);
    }
}
