<?php

namespace App\Http\Middleware;

use App\Http\Exception\RoleException;
use App\Http\Trait\RoleTrait;
use App\Models\User;
use App\RoleType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUserRole
{
    use RoleTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**@var User */
        $user = $request->attributes->get('user');
        $roleName = $this->getRoleName($user->roleId());
        if ($roleName !== (RoleType::SUPER_ADMIN || RoleType::ADMIN)) {
            throw RoleException::unAuthorizedUser();
        }
        return $next($request);
    }
}
