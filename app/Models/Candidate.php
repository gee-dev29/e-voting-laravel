<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Candidate extends Model
{
    protected $fillable = [
        'fullName',
        'age',
        'citizenship',
        'residency',
        'mentalCapacity',
        'votingParty'
    ];

    protected $table = 'candidate';

    public static function registerCandidate(array $data)
    {
        $validator = Validator::make($data, [
            'fullName' => 'required|string',
            'age' => 'required|integer',
            'citizenship' => 'required|string',
            'residency' => 'required|string',
            'mentalCapacity' => 'required|string',
            'votingParty' => 'required|string'
        ]);

        $validatedData = $validator->validate();

        return self::create($validatedData);
    }

    public function updateCandidate(array $data)
    {
        $validator = Validator::make($data, [
            'fullName' => 'sometimes|string',
            'age' => 'sometimes|integer',
            'citizenship' => 'sometimes|string',
            'residency' => 'sometimes|string',
            'mentalCapacity' => 'sometimes|string',
            'votingParty' => 'sometimes|string'
        ]);

        $validatedData = $validator->validate();

        $this->fill($validatedData);
        $this->save();

        return $this;
    }

    public function data(): array
    {
        return [
            'fullName' => $this->fullName,
            'age' => $this->age,
            'citizenship' => $this->citizenship,
            'residency' => $this->residency,
            'mentalCapacity' => $this->mentalCapacity,
            'votingParty' => $this->votingParty
        ];
    }
}
