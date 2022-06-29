@extends('admin.layouts.app')

@section('ib-content-body')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <a href="{{ route('users.profile') }}">
                    <div class="card">
                        <div class="card-body">
                            My Profile
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('movements.index') }}">
                    <div class="card">
                        <div class="card-body">
                            My Movements
                        </div>
                    </div>
                </a>
            </div>

            @authCheck('std|home|index')
            test
            @endif

            @authCheck('risk_movementRequest_approvals')
            <div class="col">
                <a href="{{ route('approvals.index') }}">
                    <div class="card">
                        <div class="card-body">
                            Movement Request Approvals
                        </div>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection
