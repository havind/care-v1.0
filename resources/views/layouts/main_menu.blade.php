@if(Auth::check())
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li id="create" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                <span class="material-icons-outlined">add_box</span> Create
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="color: #0f6674;">
                <li>
                    <a class="dropdown-item" href="{{ route('movements.create') }}">Movement Request</a>
                </li>
                @if($ibFunctions::check_permission('risk_index'))
                    @if($ibFunctions::check_permission('risk_location_index'))
                        <li>
                            <a class="dropdown-item" href="{{ route('locations.create') }}">Location</a>
                        </li>
                    @endif
                @endif
                @if($ibFunctions::check_permission('humanResource_index'))
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if($ibFunctions::check_permission('humanResource_staff_index'))
                        <li>
                            <a class="dropdown-item" href="{{ route('staff.create') }}">Staff</a>
                        </li>
                    @endif
                    @if($ibFunctions::check_permission('humanResource_department_index'))
                        <li>
                            <a class="dropdown-item" href="{{ route('departments.create') }}">Department</a>
                        </li>
                    @endif
                @endif
                @if($ibFunctions::check_permission('finance_index'))
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if($ibFunctions::check_permission('finance_fundCode_index'))
                        <li>
                            <a class="dropdown-item" href="{{ route('fund-codes.create') }}">Fund Code</a>
                        </li>
                    @endif
                    @if($ibFunctions::check_permission('finance_budgetLine_index'))
                        <li>
                            <a class="dropdown-item" href="{{ route('budget-lines.create') }}">Budget Line</a>
                        </li>
                    @endif
                @endif
            </ul>
        </li>
        @if($ibFunctions::check_permission('risk_index'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('risk.index') }}">Risk</a>
            </li>
        @endif
        @if($ibFunctions::check_permission('humanResource_index'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('human-resources.index') }}">Human Resources</a>
            </li>
        @endif
        @if($ibFunctions::check_permission('finance_index'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('finance.index') }}">Finance</a>
            </li>
        @endif
        @if($ibFunctions::check_permission('admin_index'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('a.index') }}">Administration</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" target="_blank" href="{{ url('http://212.237.125.204:1992') }}">
                CARE NAS <span class="material-icons-outlined">link</span>
            </a>
        </li>
    </ul>
@endif
