<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('cars.show', $car->id) }}">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('cars.edit', $car->id) }}">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('cars.delete', $car->id) }}">Delete</a>
    </li>
</ul>
