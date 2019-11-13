<!-- Modal -->
<div class="modal fade" id="usersForm" tabindex="-1" role="dialog" aria-labelledby="usersForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga utilizator
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/users/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Nume utilizator" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email utilizator" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password1" id="password1" placeholder="Parola" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Repeta Parola" required>
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary new-user">Salveaza</button>
        </form>
      </div>
    </div>
  </div>
</div>
