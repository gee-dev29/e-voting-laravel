<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Http\Id\RoleId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Candidate extends Model
{
    protected $table = 'candidate';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    protected $fillable = [
        'firstName',
        'lastName',
        'age',
        'citizenship',
        'residency',
        'mentalCapacity',
        'votingParty',
        'town',
        'lga',
        'stateOfOrigin',
        'stateByBirth'
    ];

    public static function RegisterCandidate(array $data)
    {
        $validator = Validator::make($data, [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'age' => 'required|integer',
            'citizenship' => 'required|string',
            'nationaliy' => 'required|string',
            'residency' => 'required|string',
            'mentalCapacity' => 'required|string',
            'votingParty' => 'required|string',
            'town' => 'required|string',
            'lga' => 'required|string',
            'stateOfOrigin' => 'required|string',
            'birthPlace' => 'required|string',
            'roleId' => 'required|string',
            'status' => ApprovalStatus::PENDING_APPROVAL
        ]);

        $validatedData = $validator->validate();
        $candidate = new self();
        $candidate->firstName = ucwords($validatedData['firstName']);
        $candidate->lastName = ucwords($validatedData['lastName']);
        $candidate->email = $validatedData['email'];

        return $candidate;
    }

    public function updateCandidate(array $data)
    {
        $validator = Validator::make($data, [
            'firstName' => 'sometimes|string',
            'lastName' => 'sometimes|string',
            'age' => 'sometimes|integer',
            'citizenship' => 'sometimes|string',
            'residency' => 'sometimes|string',
            'mentalCapacity' => 'sometimes|string',
            'votingParty' => 'sometimes|string',
            'status' => 'sometimes|string'
        ]);

        $validatedData = $validator->validate();
        $this->fill($validatedData);
        $this->save();

        return $this;
    }

    public function addRoleIdToCandidate(RoleId $roleId): void {}

    public function data(): array
    {
        return [
            'firstName' => $this->fullName,
            'lastName' => $this->fullName,
            'age' => $this->age,
            'citizenship' => $this->citizenship,
            'residency' => $this->residency,
            'mentalCapacity' => $this->mentalCapacity,
            'votingParty' => $this->votingParty,
            'town' => $this->town,
            'stateOfOrigin' => $this->stateOfOrigin,
            'stateByBirth' => $this->stateByBirth
        ];
    }
}
