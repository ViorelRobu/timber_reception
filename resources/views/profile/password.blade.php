<!-- Modal -->
<div class="modal fade" id="changeUserPassword" tabindex="-1" role="dialog" aria-labelledby="changeUserPassword" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Schimba parola
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/profile/change_password" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Vechea parola" required>
            </div>
            <div class="form-group">
                <input type="password" name="password1" id="password1" class="form-control" placeholder="Parola" required>
            </div>
            <div class="form-group">
                <input type="password" name="password2" id="password2" class="form-control" placeholder="Repeta parola" required>
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" id="changePassword" class="btn btn-primary change-class">Salveaza</button>
        </form>
      </div>
    </div>
  </div>
</div>