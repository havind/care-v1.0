<?php

namespace App\Http\Middleware;

use App\Models\UserPermissions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $permissionValue = UserPermissions::select('value')
            ->where('permission', $permission)
            ->where('user_id', Auth::id())
            ->where('is_delete', 0)
            ->exists();

        if ($permissionValue == 0) {
            abort(401, "You're not authorized to access this page.");
        }

        return $next($request);
    }
}
