<!-- modal -->
<div class="modal fade" id="receptionCommitteeForm" tabindex="-1" role="dialog" aria-labelledby="receptionCommitteeForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Creaza comisie noua
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/reception/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="company_id" id="company_id" value="{{ session()->get('company_was_selected') }}">
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Nume comisie de receptie" required>
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
