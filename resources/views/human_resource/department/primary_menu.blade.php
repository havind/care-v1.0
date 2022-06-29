<div class="row">
    <div class="col-6 px-0">
        <ul class="nav nav-tabs justify-content-start">
            <li class="nav-item">
                <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('departments.show', $department->id) }}">View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('departments.edit', $department->id) }}">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('departments.delete', $department->id) }}">Delete</a>
            </li>
        </ul>
    </div>
    <div class="col-6 px-0">
        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
                <a class="nav-link  {{ $active_primary_menu == 'staff' ? ' active' : '' }}" href="{{ route('departments.staff', $department->id) }}">Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ $active_primary_menu == 'positions' ? ' active' : '' }}" href="{{ route('departments.positions.index', $department->id) }}">Positions</a>
            </li>
        </ul>
    </div>
</div>
