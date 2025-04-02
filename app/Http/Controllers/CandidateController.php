<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function registerCandidate(Request $request)
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

    public function getCandidates()
    {
        try {
            return response()->json([
                'totalRecord' => Candidate::count(),
                'data' => Candidate::all()
            ]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

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

    // public function updateCandidateById(Request $request)
    // {
    //     try {
    //         $id = $request->route('id');
    //         $candidate = Candidate::findOrfail($id);
    //         $updateCandidate = DB::table('candidate')->where('id', $id)
    //             ->update(
    //                 $candidate->updateCandidate($updateCandidate)
    //             );
    //         if (!$candidate) {
    //             return response()->json([
    //                 'message' => 'unable to update candidate',
    //                 400
    //             ]);
    //         }
    //         return response()->json([
    //             'message' => 'Candidate data update successful',
    //             200
    //         ]);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

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
