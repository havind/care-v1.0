<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('fund-codes.show', $fund_code->id) }}">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('fund-codes.edit', $fund_code->id) }}">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('fund-codes.delete', $fund_code->id) }}">Delete</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger" href="#"></a>
    </li>
</ul>
