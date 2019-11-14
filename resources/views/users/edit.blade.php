<!-- Modal -->
<div class="modal fade" id="editUsersForm" tabindex="-1" role="dialog" aria-labelledby="editUsersForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Editeaza utilizator
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/users/add" method="POST">
            @method('PATCH')
            @csrf
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="edit_name" placeholder="Nume utilizator" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="edit_email" placeholder="Email utilizator" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password1" id="edit_password1" placeholder="Parola">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password2" id="edit_password2" placeholder="Repeta Parola">
            </div>
            <div class="form-group">
                <select name="active" id="active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary edit-user">Salveaza</button>
        </form>
      </div>
    </div>
  </div>
</div>
