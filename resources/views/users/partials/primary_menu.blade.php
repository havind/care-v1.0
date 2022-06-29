<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'profile' ? ' active' : '' }}" href="{{ route('users.profile') }}">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'movements' ? ' active' : '' }}" href="{{ route('movements.index') }}">My Movement Requests</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'reset-password' ? ' active' : '' }}" href="{{ route('users.reset-password') }}">Reset Password</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'acting' ? ' active' : '' }}" href="{{ route('users.acting') }}">Acting</a>
    </li>
</ul>
