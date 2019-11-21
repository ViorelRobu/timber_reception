<!-- Modal -->
<div class="modal fade" id="addSubForm" tabindex="-1" role="dialog" aria-labelledby="addSubForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga subgrupa
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/packaging/sub/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nume grupa principala" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="main_id" id="main_id" required>
                        <option value="" selected>-- Selecteaza grupa principala --</option>
                    @foreach ($main_group as $main)
                        <option value="{{ $main->id }}">{{ $main->name }}</option>
                    @endforeach
                </select>
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary">Salveaza</button>
        </form>
      </div>
    </div>
  </div>
</div>