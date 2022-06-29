<?php

namespace App\Http\Controllers;

use App\Models\UserPermissions;
use Illuminate\Support\Facades\Auth;

class ibFunctions
{
    public function check_permission($permission_name)
    {
        return (UserPermissions::select('value')
            ->where('permission', $permission_name)
            ->firstWhere('user_id', Auth::id()))->value;
    }

    public function check_permission_by_user($user_id, $permission_name)
    {
        return (UserPermissions::select('value')
            ->where('permission', $permission_name)
            ->firstWhere('user_id', $user_id))->value;
    }
}
