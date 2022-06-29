<div class="row">
    <div class="col px-0">
        <ul class="nav nav-tabs justify-content-start">
            <li class="nav-item">
                <a class="nav-link  {{ $active_primary_menu == 'movements_schedule' ? ' active' : '' }}" href="{{ route('fleet.movements-schedule') }}">Movements Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ $active_primary_menu == 'assign_movements' ? ' active' : '' }}" href="{{ route('fleet.assign-movements') }}">Assign Movements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ $active_primary_menu == 'cars' ? ' active' : '' }}" href="{{ route('cars.index') }}">Cars</a>
            </li>
        </ul>
    </div>
</div>
