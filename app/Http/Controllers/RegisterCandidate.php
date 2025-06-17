<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterCandidate extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $candidate = new Candidate();
            $candidate->fullName = $request->input('fullName');
            $candidate->age = $request->input('age');
            $candidate->citizenship = $request->input('citizenship');
            $candidate->residency = $request->input('residency');
            $candidate->mentalCapacity = $request->input('mentalCapacity');
            $candidate->votingParty = $request->input('votingParty');
            $candidate->save();
            return response()->json([
                'message' => 'Candidate created successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating candidate',
                'error' => $e->getMessage() 
            ], 400);
        }
    }
}
