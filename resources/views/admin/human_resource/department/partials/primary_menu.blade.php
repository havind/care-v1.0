<div class="row">
    <div class="col-6 px-0">
        <ul class="nav nav-tabs justify-content-start">
            <li class="nav-item">
                <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('a.departments.show', $department->dp_id) }}">View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('a.departments.edit', $department->dp_id) }}">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('a.departments.delete', $department->dp_id) }}">Delete</a>
            </li>
        </ul>
    </div>
    <div class="col-6 px-0">
        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('a.departments.edit', $department->dp_id) }}">Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('a.departments.positions.index', $department->dp_id) }}">Positions</a>
            </li>
        </ul>
    </div>
</div>
