<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roleId = $request->attributes->get('roleId');
        if (!$roleId) {
            $post = $request->post(['roleId']);
            if (!$post) {
                throw new Exception('role id is required in the payload');
            }
            $roleIdString = $post['roleId'];
        }
        $roleId = $roleIdString;
        // query the role table for the specific role id 
        $role = Role::find($roleId);
        if (!$role) {
            throw new Exception(`role of this %roleId is not found`);
        }
        return $next($request);
    }
}
