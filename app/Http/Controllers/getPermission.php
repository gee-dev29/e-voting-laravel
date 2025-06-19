<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class getPermission extends Controller
{
    
    public function viewPermission()
    {
        $permission = Permission::all();
        $totalRecords = Permission::count();
        // $data = [];
        return response()->json(
            [
                'totalRecords' => $totalRecords,
                'data' => $permission->data()
            ]
        );
    }
}
