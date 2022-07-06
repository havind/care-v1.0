<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Department, Position, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified users.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function profile()
    {
        $profile = User::select('id', 'first_name', 'last_name', 'username', 'personal_email', 'work_email', 'personal_phone', 'work_phone', 'supervisor_id', 'acting', 'position_id', 'department_id', 'created_at', 'updated_at')
            ->firstWhere('id', Auth::id());

        if ($profile->supervisor_id == 0) {
            $supervisor = 0;
        } else {
            $supervisor = User::select('id', 'first_name', 'last_name')
                ->firstWhere('id', $profile->supervisor_id);
        }

        $department = Department::select('id', 'name')
            ->where('is_delete', 0)
            ->firstWhere('id', $profile->department_id);

        $position = Position::select('id', 'name')
            ->where('is_delete', false)
            ->firstWhere('id', $profile->position_id);

        return view('users.profile', [
            'active_primary_menu' => 'profile',
            'profile' => $profile,
            'departments' => $department,
            'positions' => $position,
            'supervisor' => $supervisor,
        ]);
    }

    /**
     * Reset password for the specified users.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function reset_password()
    {
        $profile = User::select('id', 'first_name', 'last_name')
            ->firstWhere('id', Auth::id());

        return view('users.reset_password', [
            'profile' => $profile,
            'active_primary_menu' => 'reset-password',
            'message' => null,
        ]);
    }

    /**
     * Reset password for the specified users.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        if (!Hash::check($request->input('current-password'), Auth::user()->password)) {
            return redirect()->route('users.reset-password')->withErrors([
                'wrong-password' => [' Current Password is not correct.']
            ]);
        } else {
            // Update the password with the new one.
            User::where('id', Auth::id())
                ->where('is_delete', false)
                ->update([
                    'password' => bcrypt($request->input('new-password')),
                    'updated_at' => now(),
                ]);

            return redirect()->route('users.profile')->with('success', 'Your password has being changed successfully.');
        }

    }

    /**
     * Showing the acting page
     */
    public function acting()
    {
        $profile = User::select('id', 'first_name', 'last_name')
            ->firstWhere('id', Auth::id());

        $users = User::select(
            'id', 'first_name', 'last_name', 'username', 'role_id', 'supervisor_id', 'acting')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->orderBy('first_name')
            ->get();

        $acting = User::select('acting')
            ->where('acting', '!=', 0)
            ->firstWhere('id', Auth::id());

        return view('users.acting', [
            'profile' => $profile,
            'active_primary_menu' => 'acting',
            'users' => $users,
            'acting' => ($acting == null) ? 0 : $acting->acting,
        ]);
    }

    /**
     * Updating the Acting
     */
    public function update_acting(Request $request)
    {
        $acting = $request->input('acting');
        User::where('id', Auth::id())
            ->update(['acting' => $acting]);

        return redirect()->route('users.acting');
    }
}
