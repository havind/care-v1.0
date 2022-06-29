<nav class="nav">
    <a class="nav-link {{ $content_action_active == 'view' ? 'active' : '' }}" href="{{ route('a.human-resources.users.show', $user->user_id) }}">View</a>
    <a class="nav-link {{ $content_action_active == 'edit' ? 'active' : '' }}" href="{{ route('a.human-resources.users.edit', $user->user_id) }}">Edit</a>
    <a class="nav-link {{ $content_action_active == 'permission' ? 'active' : '' }}" href="{{ route('a.human-resources.users.permissions', $user->user_id) }}">Permission</a>
    <a class="nav-link {{ $content_action_active == 'reset-password' ? 'active' : '' }}" href="{{ route('a.human-resources.users.reset-password', $user->user_id) }}">Reset Password</a>
    <a class="nav-link text-danger {{ $content_action_active == 'delete' ? 'active' : '' }}" href="{{ route('a.human-resources.users.delete', $user->user_id) }}">Delete</a>
</nav>
