<ul class="nav nav-tabs d-print-none">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('movement-requests.show', $movement_request->id) }}">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('movement-requests.delete', $movement_request->id) }}">Cancel</a>
    </li>
</ul>
