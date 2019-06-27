<!-- Modal -->
<div class="modal fade" id="supplierGroupForm" tabindex="-1" role="dialog" aria-labelledby="supplierGroupForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga grup
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/supplier_group/add" method="POST">
            @method('POST')
            @csrf
            <div class="form-group">
                <input type="hidden" name="id" id="id">
                <input type="text" class="form-control" id="name" name="name" placeholder="Denumire grup" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Denumire grup EN" required>
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