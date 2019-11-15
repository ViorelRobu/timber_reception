<!-- Modal -->
<div class="modal fade" id="changeUserDetails" tabindex="-1" role="dialog" aria-labelledby="changeUserDetails" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Editeaza nume utilizator
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/profile/change_name" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" placeholder="Nume">
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary change-class">Salveaza</button>
        </form>
      </div>
    </div>
  </div>
</div>