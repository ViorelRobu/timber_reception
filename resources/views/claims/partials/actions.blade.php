@can('admin')
    <a href="#" class="history" id="{{ $data->id }}"data-toggle="modal" data-target="#historyForm"><i class="fa fa-history"></i></a>
@endcan

<a href="#" class="edit" id="{{ $data->id }}"data-toggle="modal" data-target="#claimsForm"><i class="fa fa-edit"></i></a>

@can('admin')
    <a href="#" class="delete" id="{{ $data->id }}"data-toggle="modal" data-target="#deleteClaimForm"><i class="fa fa-trash"></i></a>
@endcan

<a href="#" class="status" id="{{ $data->id }}"data-toggle="modal" data-target="#changeStatusForm"><i class="fa fa-fast-forward"></i></a>
