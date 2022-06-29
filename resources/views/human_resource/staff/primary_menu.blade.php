<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('staff.show', $user->id) }}">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('staff.edit', $user->id) }}">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('staff.delete', $user->id) }}">Deactivate</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger" href="#"></a>
    </li>
</ul>
