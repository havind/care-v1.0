<ul class="nav nav-tabs">
    @authCheck('humanResource_staff_show')
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? 'active' : '' }}" href="{{ route('staff.show', $user->id) }}">View</a>
    </li>
    @endif
    @authCheck('humanResource_staff_edit')
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'edit' ? 'active' : '' }}" href="{{ route('staff.edit', $user->id) }}">Edit</a>
    </li>
    @endif
    @authCheck('humanResource_staff_delete')
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? 'active' : '' }}" href="{{ route('staff.delete', $user->id) }}">Deactivate</a>
    </li>
    @endif
</ul>
