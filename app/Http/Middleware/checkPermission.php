<?php

namespace App\Http\Middleware;

use App\Domain\Id\PermissionId;
use App\Http\Id\PermissionId as IdPermissionId;
use App\Models\Permission;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $permissionIdString = $request->get('permissionId');
        if (!$permissionIdString) {
            try {
                $post = $request->post();
                //code to validate for notEmptyKey and UUID
                if($request->array_key_exists('permissionId', $post) === false){
                    throw new Exception('Permission ID is required');
                };
                $permissionIdString = $post['permissionId'];
                $permissionId = IdPermissionId::fromString($permissionIdString);
            } catch (\Throwable $th) {
                throw new Exception($th->getMessage());
            }
        }
        // $permission = $request->get('permission')
        if (!$permission) {
            throw new Exception(`$permission, not found`);
        }
        return $next($request);
    }
}
