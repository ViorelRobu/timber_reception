@can('admin')
    <a href="#" class="history" id="{{ $data->id }}"data-toggle="modal" data-target="#historyForm"><i class="fa fa-history"></i></a>
@endcan

@can('superadmin')
    @if ($data->status_id == 2)
        <a href="#" class="reactivate" id="{{ $data->id }}"data-toggle="modal" data-target="#reactivateForm"><i class="fa fa-power-off"></i></a>
    @endif
@endcan

@if ($data->status_id == 1)
    <a href="#" class="edit" id="{{ $data->id }}"data-toggle="modal" data-target="#claimsForm"><i class="fa fa-edit"></i></a>
@endif

<a href="/claims/{{ $data->id }}/print/ro" style="color: green" target="_blank"><i class="fa fa-print"></i></a>
<a href="/claims/{{ $data->id }}/print/en" style="color: red" target="_blank"><i class="fa fa-print"></i></a>

<a href="#" class="status" id="{{ $data->id }}"data-toggle="modal" data-target="#changeStatusForm"><i class="fa fa-fast-forward"></i></a>

@can('admin')
    <a href="#" class="delete" id="{{ $data->id }}"data-toggle="modal" data-target="#deleteClaimForm" style="color: red"><i class="fa fa-trash"></i></a>
@endcan

