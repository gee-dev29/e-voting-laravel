<?php

namespace App\Http\Middleware;

use App\Http\Id\RoleId;
use App\Models\Role;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roleIdString = $request->route('roleId');
        if (!$roleIdString) {
            $post = $request->post();
            $roleIdString = $post['roleId'] ?? null;
            if (!$post) {
                throw new Exception('role id is required in the payload');
            }
        }
        $roleId = RoleId::fromString($roleIdString);
        $role = Role::where(['id' => $roleId])->first();
        if (!$role) {
            throw new Exception(`role of this %roleId is not found`);
        }
        $request->attributes->set('role', $role);
        return $next($request);
    }
}
