<!-- Modal -->
<div class="modal fade" id="companyForm" tabindex="-1" role="dialog" aria-labelledby="companyForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga firma noua
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/companies/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Denumire firma" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="label" name="label" placeholder="Denumire scurta" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="cui" name="cui" placeholder="Cod Unic de Inregistrare" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="j" name="j" placeholder="Numar inregistrare registrul comertului" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="address" name="address" placeholder="Adresa firma" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Cont" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="bank" name="bank" placeholder="Banca" required>
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
