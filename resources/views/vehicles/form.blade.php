<!-- Modal -->
<div class="modal fade" id="vehiclesForm" tabindex="-1" role="dialog" aria-labelledby="countriesForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga mijloc de transport
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/vehicles/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Mijloc de transport RO" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Mijloc de transport EN" required>
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