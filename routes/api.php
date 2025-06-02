<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\rolePermissionController;
use App\Http\Controllers\UserController;
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
Route::post('/user', [
  UserController::class,
  'createUser'
]);

Route::middleware([
  'check.user',
])->group(function () {
  Route::delete('/user/{userId}/delete', [UserController::class, 'deleteUser']);
  Route::get('/user/{userId}', [UserController::class, 'getUser']);
  Route::patch('/user/{userId}/change-user-password', [UserController::class, 'changeUserPassword']);
  Route::patch('/user/{userId}/update', [UserController::class, 'updateUserDetails']);
});

Route::middleware([
  'check.user',
])->group(function () {
  Route::patch('/role/{roleId}/permissions', [RolePermissionController::class, 'addRolePermisssions']);
});

Route::get('/user', [
  UserController::class,
  'getUsers'
]);

// role route
Route::middleware([
  'check.role',
])->group(function () {
  Route::delete('/role/{roleId}/delete', [RoleController::class, 'deleteRole']);
  Route::patch('/role/{roleId}/update', [RoleController::class, 'updateRole']);
  Route::get('/role/{roleId}', [RoleController::class, 'getRole']);
});

Route::post('/role', [
  RoleController::class,
  'createRole'
]);

Route::get('/role', [
  RoleController::class,
  'getRoles'
]);

// permissions route
Route::post('/permission', [
  PermissionController::class,
  'createPermission'
]);

Route::get('/permission', [
  PermissionController::class,
  'viewPermission'
]);
