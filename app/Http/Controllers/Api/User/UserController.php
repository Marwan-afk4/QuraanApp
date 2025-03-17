<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Ad3ya;
use App\Models\Ahadeth;
use App\Models\Ayat;
use App\Models\Azkar;
use App\Models\AzkarCategory;
use App\Models\Emotion;
use App\Models\EmotionAll;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getAd3ya(){
        $ad3ya = Ad3ya::all();
        $data =[
            'ad3ya'=>$ad3ya
        ];
        return response()->json($data);
    }

    public function getAzkar(){
        $azkar = Azkar::all();
        $data =[
            'azkar'=>$azkar
        ];
        return response()->json($data);
    }

    public function getAhadeth(){
        $ahadeth = Ahadeth::all();
        $data =[
            'ahadeth'=>$ahadeth
        ];
        return response()->json($data);
    }

    public function getAyat(){
        $ayat = Ayat::all();
        $data =[
            'ayat'=>$ayat
        ];
        return response()->json($data);
    }

    public function foryouPage(){
        $randomAd3ya = Ad3ya::inRandomOrder()->limit(9)->get();
        $randomAhadeth = Ahadeth::inRandomOrder()->limit(9)->get();
        $randomAyat = Ayat::inRandomOrder()->limit(9)->get();

        $data =[
            'randomAd3ya'=>$randomAd3ya,
            'randomAhadeth'=>$randomAhadeth,
            'randomAyat'=>$randomAyat
        ];

        return response()->json($data,200);

    }

    public function getEmotions(){
        $emotions = Emotion::all();
        $data =[
            'emotions'=>$emotions
        ];
        return response()->json($data);
    }

    public function getemotionthings($emotion_id)
{
    $emotionRecords = EmotionAll::where('emotion_id', $emotion_id)
        ->with('emotion', 'ayat', 'ad3ya', 'ahadeth', 'azkar')
        ->get();

    if ($emotionRecords->isEmpty()) {
        return response()->json(['message' => 'No data found'], 404);
    }

    $formattedResponse = [
        'emotion_id' => $emotionRecords[0]->emotion->id,
        'emotion_name' => $emotionRecords[0]->emotion->emotion_name,
        'emotion_limit' => $emotionRecords[0]->emotion->emotion_limit,
        'ayat' => [],
        'ad3ya' => [],
        'ahadeth' => [],
        'azkar' => []
    ];

    foreach ($emotionRecords as $record) {
        if ($record->ayat) {
            $formattedResponse['ayat'][] = [
                'id' => $record->ayat->id,
                'ayat_ar' => $record->ayat->{"ayat_ar"},
                'ayat_en' => $record->ayat->{"ayat_en"},
                'status' => $record->ayat->status,
                'note' => $record->ayat->note
            ];
        }

        if ($record->ad3ya) {
            $formattedResponse['ad3ya'][] = [
                'id' => $record->ad3ya->id,
                'ad3ya_ar' => $record->ad3ya->{"ad3ya_ar"},
                'ad3ya_en' => $record->ad3ya->{"ad3ya_en"},
                'status' => $record->ad3ya->status,
                'note' => $record->ad3ya->note
            ];
        }

        if ($record->ahadeth) {
            $formattedResponse['ahadeth'][] = [
                'id' => $record->ahadeth->id,
                'ahadeth_ar' => $record->ahadeth->{"ahadeth_ar"},
                'ahadeth_en' => $record->ahadeth->{"ahadeth_en"},
                'status' => $record->ahadeth->status,
                'note' => $record->ahadeth->note
            ];
        }

        if ($record->azkar) {
            $formattedResponse['azkar'][] = [
                'id' => $record->azkar->id,
                'azkar_ar' => $record->azkar->{"azkar_ar"},
                'azkar_en' => $record->azkar->{"azkar_en"},
                'azkar_count' => $record->azkar->azkar_count,
                'category_id' => $record->azkar->category_id,
                'category_name' => $record->azkar->azkar_category->category_name,
                'status' => $record->azkar->status,
                'note' => $record->azkar->note
            ];
        }
    }

    return response()->json(['data'=>$formattedResponse]);
}

    public function getCategories(){
        $categories = AzkarCategory::all();
        $data =[
            'categories'=>$categories
        ];
        return response()->json($data);
    }

    public function getAzkarCategory($category_id){
        $azkar = Azkar::where('category_id', $category_id)->get();
        $data =[
            'azkar'=>$azkar
        ];
        return response()->json($data);
    }}
