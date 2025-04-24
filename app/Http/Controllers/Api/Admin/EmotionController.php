<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emotion;
use App\Models\EmotionAll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmotionController extends Controller
{
    protected $updateEmotionAll = ['emotion_id', 'ayat_id', 'ad3ya_id', 'ahadeth_id', 'azkar_id'];

    public function getEmotion()
    {
        $emotion = Emotion::all();
        $data = [
            'emotion' => $emotion
        ];
        return response()->json($data);
    }

    public function deleteEmotion($id)
    {
        $emotion = Emotion::find($id);
        $emotion->delete();
        $data = [
            'message' => 'Emotion Deleted Successfully',
        ];
        return response()->json($data);
    }

    public function addEmotion(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'emotion_name' => 'required|string',
            'emotion_name_ar' => 'required|string',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        $emotion = Emotion::create([
            'emotion_name' => $request->emotion_name,
            'emotion_name_ar' => $request->emotion_name_ar,
        ]);

        $data = [
            'message' => 'Emotion Added Successfully',
            'emotion' => $emotion
        ];

        return response()->json($data);
    }

    //Add things to emotions

    public function addtoEmotions(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'emotion_id' => 'required|integer|exists:emotions,id',
            'ayat_id' => 'nullable|integer|exists:ayats,id',
            'ad3ya_id' => 'nullable|integer|exists:ad3yas,id',
            'ahadeth_id' => 'nullable|integer|exists:ahadeths,id',
            'azkar_id' => 'nullable|integer|exists:azkars,id',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }

        $emotionId = $request->emotion_id;
        $inserted = [];

        if ($request->filled('ayat_id')) {
            $inserted[] = EmotionAll::create([
                'emotion_id' => $emotionId,
                'ayat_id' => $request->ayat_id,
            ]);
        }

        if ($request->filled('ad3ya_id')) {
            $inserted[] = EmotionAll::create([
                'emotion_id' => $emotionId,
                'ad3ya_id' => $request->ad3ya_id,
            ]);
        }

        if ($request->filled('ahadeth_id')) {
            $inserted[] = EmotionAll::create([
                'emotion_id' => $emotionId,
                'ahadeth_id' => $request->ahadeth_id,
            ]);
        }

        if ($request->filled('azkar_id')) {
            $inserted[] = EmotionAll::create([
                'emotion_id' => $emotionId,
                'azkar_id' => $request->azkar_id,
            ]);
        }

        return response()->json([
            'message' => 'Emotion(s) added successfully.',
            'emotions' => $inserted
        ]);
    }


    public function deleteEmotionAllByType(Request $request)
    {
        $emotionId = $request->input('emotion_id');
        $azkarId = $request->input('azkar_id');
        $ayatId = $request->input('ayat_id');
        $ahadethId = $request->input('ahadeth_id');
        $ad3yaId = $request->input('ad3ya_id');

        if (!$emotionId) {
            return response()->json(['message' => 'emotion_id is required'], 422);
        }

        $query = EmotionAll::where('emotion_id', $emotionId);

        $query->where(function ($q) use ($azkarId, $ayatId, $ahadethId, $ad3yaId) {
            if ($azkarId) {
                $q->orWhere('azkar_id', $azkarId);
            }
            if ($ayatId) {
                $q->orWhere('ayat_id', $ayatId);
            }
            if ($ahadethId) {
                $q->orWhere('ahadeth_id', $ahadethId);
            }
            if ($ad3yaId) {
                $q->orWhere('ad3ya_id', $ad3yaId);
            }
        });

        $deleted = $query->delete();

        return response()->json([
            'message' => $deleted > 0 ? 'Selected Emotion entries deleted successfully.' : 'No matching records found to delete.',
        ]);
    }


    public function updateEmotionAll(Request $request, $id)
    {
        $emotion = EmotionAll::find($id);
        $validation = Validator::make($request->all(), [
            'emotion_id' => 'nullable|integer|exists:emotions,id',
            'ayat_id' => 'nullable|integer|exists:ayats,id',
            'ad3ya_id' => 'nullable|integer|exists:ad3yas,id',
            'ahadeth_id' => 'nullable|integer|exists:ahadeths,id',
            'azkar_id' => 'nullable|integer|exists:azkars,id',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }
        $updateEmotionAll = $request->only($this->updateEmotionAll);
        $emotion->update($updateEmotionAll);
        $data = [
            'message' => 'Emotion Updated Successfully',
            'emotion' => $emotion
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
                    'aya_en' => $record->ayat->{"ayat_en"},
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
                    'azkar_category_id' => $record->azkar->category_id,
                    'azkar_category_name' => $record->azkar->azkar_category->category_name,
                    'status' => $record->azkar->status,
                    'note' => $record->azkar->note
                ];
            }
        }

        return response()->json(['data' => $formattedResponse]);
    }

    public function editallLimits(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'limit' => 'required|integer',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }
        $emotions = User::where('role', 'user')->get();
        foreach ($emotions as $emotion) {
            $emotion->update([
                'limit' => $request->limit
            ]);
        }
        $data = [
            'message' => 'All Emotions Limits Updated Successfully to ' . $request->limit,
        ];
        return response()->json($data);
    }

    public function getUsersLimit()
    {
        $users = User::where('role', 'user')->get();
        $data = $users->map(function ($user) {
            return [
                'usres_limit' => $user->limit,
            ];
        });
        return response()->json($data);
    }
}
