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

@can('admin')
    <a href="#" class="delete" id="{{ $data->id }}"data-toggle="modal" data-target="#deleteClaimForm"><i class="fa fa-trash"></i></a>
@endcan

<a href="#" class="status" id="{{ $data->id }}"data-toggle="modal" data-target="#changeStatusForm"><i class="fa fa-fast-forward"></i></a>
