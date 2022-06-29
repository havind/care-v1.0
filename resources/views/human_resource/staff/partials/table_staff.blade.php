<table class="table table-sm table-bordered table-hover">
    <thead>
    <tr class="text-center">
        <td class="align-middle">#</td>
        <td class="align-middle">Full name</td>
        <td class="align-middle" style="width: 20%;">Position</td>
        <td class="align-middle">Department</td>
        <td class="align-middle">E-mail</td>
        <td class="align-middle">Phone Number</td>
        <td class="align-middle">Actions</td>
    </tr>
    </thead>
    <tbody>
    @foreach($staff as $_staff)
        <tr>
            <td class="align-middle text-center">{{ $loop->iteration }}</td>
            <td class="align-middle">
                <a href="{{ route('staff.show', $_staff->id) }}">{{ $_staff->first_name }} {{ $_staff->last_name }}</a>
            </td>
            <td class="align-middle">
                @foreach($positions as $position)
                    @if($position->id == $_staff->position_id)
                        <a href="{{ route('departments.positions.show', [$position->department_id, $position->id]) }}">{{ $position->name }}</a>
                    @endif
                @endforeach
            </td>
            <td class="align-middle">
                @foreach($departments as $department)
                    @if($department->id == $_staff->department_id)
                        <a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a>
                    @endif
                @endforeach
            </td>
            <td class="align-middle">
                @if(!empty($_staff->personal_email))
                    <span class="material-icons">person</span> {{ $_staff->personal_email }}
                    <br/>
                @endif
                @if(!empty($_staff->work_email))
                    <span class="material-icons">work_outline</span> {{ $_staff->work_email }}
                @endif
            </td>
            <td class="align-middle">
                @if(!empty($_staff->personal_phone))
                    <span class="material-icons">person</span> +{{ $_staff->personal_phone }}
                    <br/>
                @endif
                @if(!empty($_staff->work_phone))
                    <span class="material-icons">work_outline</span> +{{ $_staff->work_phone }}
                @endif
            </td>
            <td class="align-middle text-center">
                <ul class="list-inline mb-0">
                    @authCheck('humanResource_staff_edit')
                    <li class="list-inline-item">
                        <a class="text-info" href="{{ route('staff.edit', $_staff->id) }}">
                            <span class="material-icons">mode_edit</span>
                        </a>
                    </li>
                    @endif
                    @authCheck('humanResource_staff_delete')
                    <li class="list-inline-item">
                        <a class="text-danger" href="{{ route('staff.delete', $_staff->id) }}">
                            <span class="material-icons">delete</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{--    Pagination  --}}
{{ $staff->links('human_resource.staff.pagination') }}
