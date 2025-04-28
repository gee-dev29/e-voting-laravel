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

Route::get('/view-candidates', [
  CandidateController::class,
  'getCandidates'
]);

Route::get('/view-candidate/{id}', [
  CandidateController::class,
  'getCandidate'
]);

Route::delete('/remove-candidate/{id}', [
  CandidateController::class,
  'deleteCandidate'
]);

Route::patch('/update-candidate/{id}', [
  CandidateController::class,
  'updateCandidateById'
]);

// user route
Route::post('/user', [
  UserController::class,
  'createUser'
]);

Route::get('/user/{userId}', [
  UserController::class,
  'getUser'
]);

Route::delete('/user/{userId}', [
  UserController::class,
  'deleteUser'
]);

Route::get('/users', [
  UserController::class,
  'getUsers'
]);

// role route
Route::post('/role', [
  RoleController::class,
  'createRole'
]);
Route::get('/role/{roleId}', [
  RoleController::class,
  'getRole',
]);
Route::get('/role/{roleId}', [
  RoleController::class,
  'deleteRole'
]);
Route::get('/role/{roleId}', [
  RoleController::class,
  'updateRole'
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

// role permission route
Route::post('/role/{roleId}/permissions', [
  rolePermissionController::class,
  "addRolePermisssions"
]);
