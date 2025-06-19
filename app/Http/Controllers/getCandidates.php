<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class getCandidates extends Controller
{
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
}
