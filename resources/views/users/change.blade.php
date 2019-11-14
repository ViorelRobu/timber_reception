<!-- Modal -->
<div class="modal fade" id="changeRoleForm" tabindex="-1" role="dialog" aria-labelledby="changeRoleForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Schimba clasa utilizatorului <span id="username"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/users/add" method="POST">
            @method('PATCH')
            @csrf
            <input type="hidden" name="id" id="role_id" value="">
            <div class="form-group">
                <select name="role" id="role" class="form-control">
                    <option value="1">SuperAdmin</option>
                    <option value="2">Administrator</option>
                    <option value="3">User</option>
                    <option value="4">Viewer</option>
                </select>
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
