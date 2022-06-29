output += `
<ul class="list-inline" style="margin-bottom: unset !important;">
    <li class="list-inline-item">
        <a href="' + ('{{ route("a.human-resources.users.permissions", ":user_id") }}').replace(':user_id', value['id']) + '">
            <span class="material-icons text-danger">vpn_key</span></a>
    </li>
    <li class="list-inline-item">
        <a href="' + ('{{ route("a.human-resources.users.reset-password", ":user_id") }}').replace(':user_id', value['id']) + '">
            <span class="material-icons text-warning">lock_reset</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a href="' + ('{{ route("a.human-resources.users.edit", ":user_id") }}').replace(':user_id', value['id']) + '">
            <span class="material-icons text-info">mode_edit</span>
        </a>
    </li>
    <li class="list-inline-item">
        <a href="' + ('{{ route("a.human-resources.users.delete", ":user_id") }}').replace(':user_id', value['id']) + '">
            <span class="material-icons text-danger">delete</span>
        </a>
    </li>
</ul>`;
