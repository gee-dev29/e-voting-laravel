<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class deleteCandidate extends Controller
{
    public function deleteCandidate(Request $request)
    {
        try {
            $id = $request->route('id');
            $candidate = DB::table('candidate')->where('id', $id)->delete();
            if (!$candidate) {
                return 'could not delete candidate';
            }
            return response()->json([
                'message' => "candidate deleted successfully",
                204
            ]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
