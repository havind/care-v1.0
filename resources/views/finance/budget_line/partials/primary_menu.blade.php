<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'view' ? ' active' : '' }}" href="{{ route('budget-lines.show', $budget_line->id) }}">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active_primary_menu == 'edit' ? ' active' : '' }}" href="{{ route('budget-lines.edit', $budget_line->id) }}">Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger {{ $active_primary_menu == 'delete' ? ' active' : '' }}" href="{{ route('budget-lines.delete', $budget_line->id) }}">Delete</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger" href="#"></a>
    </li>
</ul>
