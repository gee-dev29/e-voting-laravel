<?php

use App\Http\Controllers\AddRolePermissions;
use App\Http\Controllers\AssignUserRole;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ChangeUserPassword;
use App\Http\Controllers\CreateRole;
use App\Http\Controllers\createUser;
use App\Http\Controllers\DeleteRole;
use App\Http\Controllers\DeleteUser;
use App\Http\Controllers\FindUserByEmail;
use App\Http\Controllers\GenerateOTP;
use App\Http\Controllers\GetRole;
use App\Http\Controllers\GetRoles;
use App\Http\Controllers\GetUser;
use App\Http\Controllers\GetUserRoles;
use App\Http\Controllers\GetUsers;
use App\Http\Controllers\LoginUser;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UpdateUserDetails;
use App\Http\Controllers\VerifyOTP;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\JwtAuthentication;
use Illuminate\Support\Facades\Route;

// candidate route
Route::post('/create-candidate', [
  CandidateController::class,
  'registerCandidate'
]);

Route::middleware([
  'check.candidate',
])->group(function () {
  Route::patch('/update-candidate/{id}', [CandidateController::class, 'updateCandidateById']);
  Route::delete('/remove-candidate/{id}', [CandidateController::class, 'deleteCandidate']);
  Route::get('/view-candidate/{id}', [CandidateController::class, 'getCandidate']);
});

Route::get('/view-candidates', [
  CandidateController::class,
  'getCandidates'
]);

// user route
Route::post('/user', CreateUser::class);
Route::get('/user', GetUsers::class)->middleware(JwtAuthentication::class);
Route::patch('/user/otp', GenerateOTP::class)->middleware(FindUserByEmail::class);
Route::post('/user/validate-otp', LoginUser::class)->middleware([FindUserByEmail::class, VerifyOTP::class]);
Route::delete('/user/{userId}/delete', DeleteUser::class)->middleware([JwtAuthentication::class, CheckUser::class]);
Route::get('/user/{userId}', GetUser::class)->middleware([JwtAuthentication::class, CheckUser::class]);
Route::patch('/user/{userId}/change-user-password', ChangeUserPassword::class)->middleware([JwtAuthentication::class, CheckUser::class]);
Route::patch('/user/{userId}/update', UpdateUserDetails::class)->middleware([JwtAuthentication::class, CheckUser::class]);
Route::patch('/user/{userId}/assign-role', AssignUserRole::class)->middleware([JwtAuthentication::class, CheckUser::class]);
Route::get('/user/{userId}/user-role', GetUserRoles::class)->middleware([JwtAuthentication::class, CheckUser::class]);

// role route
Route::post('/role/{roleId}/permissions', AddRolePermissions::class)->middleware([JwtAuthentication::class, CheckRole::class]);

Route::delete('/role/{roleId}/delete', DeleteRole::class)->middleware([JwtAuthentication::class, CheckRole::class]);
Route::patch('/role/{roleId}/update',);
Route::get('/role/{roleId}', GetRole::class);

Route::post('/role', CreateRole::class)->middleware(JwtAuthentication::class);
Route::get('/role', GetRoles::class)->middleware(JwtAuthentication::class);

// permissions route
Route::post('/permission', [
  PermissionController::class,
  'createPermission'
]);

Route::get('/permission', [
  PermissionController::class,
  'viewPermission'
]);
