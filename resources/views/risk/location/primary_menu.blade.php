<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('locations.edit', $location->id) }}">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('locations.delete', $location->id) }}">Delete</a>
    </li>
</ul>
