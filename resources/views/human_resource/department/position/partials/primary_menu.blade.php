<div class="row">
    <div class="col px-0">
        <ul class="nav nav-tabs justify-content-start">
            <li class="nav-item">
                <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('departments.positions.show', [$department->id, $position->id]) }}">View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('departments.positions.edit', [$department->id, $position->id]) }}">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('departments.positions.delete', [$department->id, $position->id]) }}">Delete</a>
            </li>
        </ul>
    </div>
</div>
