Route
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

// Route::get('/view-candidate/{id}', [
//   CandidateController::class,
//   'getCandidate'
// ]);

// Route::delete('/remove-candidate/{id}', [
//   CandidateController::class,
//   'deleteCandidate'
// ]);

// Route::patch('/update-candidate/{id}', [
//   CandidateController::class,
//   'updateCandidateById'
// ]);

// user route
Route::post('/user', [
  UserController::class,
  'createUser'
]);

// Route::post('/user/update', [UserController::class, 'updateUser'])->middleware('check.user');

Route::middleware([
  'check.user',
])->group(function () {
  Route::delete('/user/{userId}/delete', [UserController::class, 'deleteUser']);
  Route::get('/user/{userId}', [UserController::class, 'getUser']);
  Route::patch('/user/{id}/update', [UserController::class, 'updateUser']);
  Route::patch('/user/{id}/change-user-password', [UserController::class, 'changeUserPassword']);
});


Route::middleware([
  'check.user',
])->group(function () {
  Route::patch('/role/{roleId}/permissions', [RolePermissionController::class, 'addRolePermisssions']);
});

Route::middleware([
  'check.role',
])->group(function () {
  Route::delete('/role/{roleId}/delete', [RoleController::class, 'deleteRole']);
  Route::patch('/role/{roleId}/update', [RoleController::class, 'updateRole']);
});
Route::get('/role/{roleId}', [RoleController::class, 'getRole']);

Route::middleware([
  'check.candidate',
])->group(function () {
  Route::patch('/update-candidate/{id}', [CandidateController::class, 'updateCandidateById']);
  Route::delete('/remove-candidate/{id}', [CandidateController::class, 'deleteCandidate']);
  Route::get('/view-candidate/{id}', [CandidateController::class, 'getCandidate']);
});

// Route::get('/user/{userId}', [
//   UserController::class,
//   'getUser'
// ]);

// Route::delete('/user/{userId}', [
//   UserController::class,
//   'deleteUser'
// ]);

Route::get('/users', [
  UserController::class,
  'getUsers'
]);

// role route
Route::post('/role', [
  RoleController::class,
  'createRole'
]);
// Route::get('/role/{roleId}', [
//   RoleController::class,
//   'getRole',
// ]);
// Route::get('/role/{roleId}', [
//   RoleController::class,
//   'deleteRole'
// ]);
// Route::get('/role/{roleId}', [
//   RoleController::class,
//   'updateRole'
// ]);
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
// Route::post('/role/{roleId}/permissions', [
//   rolePermissionController::class,
//   "addRolePermisssions"
// ]);
