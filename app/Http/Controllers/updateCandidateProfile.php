<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class updateCandidateProfile extends Controller
{
    public function updateCandidateById(Request $request)
    {
        try {
            $id = $request->route('id');
            $candidate = Candidate::findOrFail($id);
            if ($candidate) {
                $validatedData = $request->validate([
                    'fullName' => 'sometimes|string',
                    'age' => 'sometimes|integer',
                    'citizenship' => 'sometimes|string',
                    'residency' => 'sometimes|string',
                    'mentalCapacity' => 'sometimes|string',
                    'votingParty' => 'sometimes|string'
                ]);
                $candidate->updateCandidate($validatedData);

                return response()->json([
                    'message' => 'Candidate data update successful'
                ], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to update candidate',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
