<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class getCandidate extends Controller
{
    public function getCandidate(Request $request)
    {
        try {
            $id = $request->route('id');
            $candidate = Candidate::find($id);
            if ($candidate) {
                return response()->json([
                    'data' => $candidate->data(),
                ]);
            }
            return response()->json([
                'message' => 'Candidate data not found'
            ]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
