<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('movements.show', $movement_request->id) }}">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'cancel' ? ' active' : '' }}" href="{{ route('movements.delete', $movement_request->id) }}">Cancel</a>
    </li>
</ul>
