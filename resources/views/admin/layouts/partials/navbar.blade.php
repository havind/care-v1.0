<div class="accordion" id="ib-navbar-accordion">
    <div class="ib-navbar-seperator"></div>
    <div class="ib-navbar-item">
        <a aria-current="true" class="list-group-item list-group-item-action border-0 rounded-0 d-flex align-items-center {{ ($navbar_active == 'dashboard') ? 'active': '' }}" href="{{ route('a.index') }}">
            <span class="align-middle material-icons">dashboard</span>
            <span class="align-middle title">Dashboard</span>
        </a>
    </div>
    <div class="ib-navbar-seperator"></div>
    <div class="ib-navbar-accordion">
        <h2 class="ib-navbar-accordion-title" id="heading-human-resources">
            <button aria-controls="collapseOne" aria-expanded="{{ $navbar_category == 'human-resources' ? 'true' : 'false' }}" class="text-start collapsed {{ $navbar_category == 'human-resources' ? 'active' : '' }}" data-bs-target="#collapse-human-resources" data-bs-toggle="collapse" type="button">
                Human Resources
            </button>
        </h2>
        <div id="collapse-human-resources" class="ib-navbar-accordion-item collapse {{ $navbar_category == 'human-resources' ? 'show' : '' }}" aria-labelledby="heading-human-resources" data-bs-parent="#ib-navbar-accordion">
            <div class="accordion-body p-0">
                <div class="list-group rounded-0">
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'users' ? 'active' : '' }}" href="{{ route('a.human-resources.users.index') }}">
                        <span class="align-middle material-icons">group</span>
                        <span class="align-middle title">Users</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'departments' ? 'active' : '' }}" href="{{ route('a.human-resources.departments.index') }}">
                        <span class="align-middle material-icons">lan</span>
                        <span class="align-middle title">Departments</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action {{ $navbar_active == 'leaves' ? 'active' : '' }}">
                        <span class="align-middle material-icons">receipt_long</span>
                        <span class="align-middle title">Leaves</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action {{ $navbar_active == 'timesheet' ? 'active' : '' }}">
                        <span class="align-middle material-icons">schedule</span>
                        <span class="align-middle title">Timesheet</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="ib-navbar-seperator"></div>
    <div class="ib-navbar-accordion">
        <h2 class="ib-navbar-accordion-title" id="heading-finance">
            <button aria-controls="collapse-finance" aria-expanded="false" class="text-start collapsed {{ $navbar_category == 'finance' ? 'active' : '' }}" data-bs-target="#collapse-finance" data-bs-toggle="collapse" type="button">
                Finance
            </button>
        </h2>
        <div id="collapse-finance" class="ib-navbar-accordion-item collapse {{ $navbar_category == 'finance' ? 'show' : '' }}" aria-labelledby="heading-finance" data-bs-parent="#ib-navbar-accordion">
            <div class="accordion-body p-0">
                <div class="list-group rounded-0">
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'projects' ? 'active' : '' }}" href="{{ route('a.projects.index') }}">
                        <span class="align-middle material-icons">business_center</span>
                        <span class="align-middle title">Projects</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'fund-codes' ? 'active' : '' }}" href="{{ route('a.fund-codes.index') }}">
                        <span class="align-middle material-icons" title="Fund codes">paid</span>
                        <span class="align-middle title">Fund codes</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'budget-lines' ? 'active' : '' }}" href="{{ route('a.budget-lines.index') }}">
                        <span class="align-middle material-icons">attach_money</span>
                        <span class="align-middle title">Budget lines</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{--    Risk    --}}
    <div class="ib-navbar-seperator"></div>
    <div class="ib-navbar-accordion">
        <h2 class="ib-navbar-accordion-title" id="heading-risk">
            <button aria-controls="collapse-risk" aria-expanded="false" class="text-start collapsed {{ $navbar_category == 'risk' ? 'active' : '' }}" data-bs-target="#collapse-risk" data-bs-toggle="collapse" type="button">
                Risk
            </button>
        </h2>
        <div id="collapse-risk" class="ib-navbar-accordion-item collapse {{ $navbar_category == 'risk' ? 'show' : '' }}" aria-labelledby="heading-risk" data-bs-parent="#ib-navbar-accordion">
            <div class="accordion-body p-0">
                <div class="list-group rounded-0">
                    <a class="list-group-item list-group-item-action  {{ $navbar_active == 'movement-requests' ? 'active' : '' }}" href="{{ route('a.risk.movement-requests.index') }}">
                        <span class="align-middle material-icons">timeline</span>
                        <span class="align-middle title">Movement Requests</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'projects' ? 'active' : '' }}" href="#">
                        <span class="align-middle material-icons">calendar_month</span>
                        <span class="align-middle title">Movement Schedule</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'projects' ? 'active' : '' }}" href="#">
                        <span class="align-middle material-icons">assignment</span>
                        <span class="align-middle title">Approved Movements</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'projects' ? 'active' : '' }}" href="#">
                        <span class="align-middle material-icons">approval</span>
                        <span class="align-middle title">Approvals</span>
                    </a>
                    <a class="list-group-item list-group-item-action {{ $navbar_active == 'vehicles' ? 'active' : '' }}" href="{{ route('a.fund-codes.index') }}">
                        <span class="align-middle material-icons">directions_car</span>
                        <span class="align-middle title">Vehicles</span>
                    </a>
                    <a class="list-group-item list-group-item-action  {{ $navbar_active == 'locations' ? 'active' : '' }}" href="{{ route('a.budget-lines.index') }}">
                        <span class="align-middle material-icons">my_location</span>
                        <span class="align-middle title">Locations</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{--    Admin    --}}
    <div class="ib-navbar-seperator"></div>
    <div class="ib-navbar-accordion">
        <h2 class="ib-navbar-accordion-title" id="heading-admin">
            <button aria-controls="collapse-admin" aria-expanded="false" class="text-start collapsed {{ $navbar_category == 'admin' ? 'active' : '' }}" data-bs-target="#collapse-admin" data-bs-toggle="collapse" type="button">
                Admin
            </button>
        </h2>
        <div id="collapse-admin" class="ib-navbar-accordion-item collapse {{ $navbar_category == 'admin' ? 'show' : '' }}" aria-labelledby="heading-risk" data-bs-parent="#ib-navbar-accordion">
            <div class="accordion-body p-0">
                <div class="list-group rounded-0">
                    <a class="list-group-item list-group-item-action  {{ $navbar_active == 'accommodation' ? 'active' : '' }}" href="{{ route('a.admin.accommodation.index') }}">
                        <span class="align-middle material-icons">hotel</span>
                        <span class="align-middle title">Accommodation</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


</div>
<button class="btn bg-secondary border-0 rounded-0 text-white position-absolute bottom-0" type="button" id="navbar-collapse" aria-expanded="false" style="height: 40px; width: 200px;">
    <span class="material-icons">chevron_left</span>
</button>
