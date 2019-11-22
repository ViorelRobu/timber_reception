<!-- Modal -->
<div class="modal fade" id="supplierForm" tabindex="-1" role="dialog" aria-labelledby="supplierForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga furnizor
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/suppliers/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
                <input type="text" class="form-control" name="fibu" id="fibu" placeholder="Fibu" required>
            </div>
            <div class="form-group">
                <select class="custom-select form-control" name="packaging_calculation" id="packaging_calculation" required>
                    <option value="" selected>--- Specifica daca se calculeaza automat ambalajele ---</option>
                        <option value="1">Activ</option>
                        <option value="0">Inactiv</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Denumire furnizor" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="cui" id="cui" placeholder="Cod Unic Inregistrare">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="j" id="j" placeholder="Numar Registru Comert">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" id="address" placeholder="Adresa furnizor" required>
            </div>
            <div class="form-group">
                <select class="custom-select form-control" name="country_id" id="country_id" required>
                    <option value="" selected>--- Alege tara de rezidenta ---</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select form-control" name="supplier_group_id" id="supplier_group_id" required>
                    <option value="" selected>--- Alege grupul furnizorului ---</option>
                    @foreach ($supplier_groups as $supplier_group)
                        <option value="{{ $supplier_group->id }}">{{ $supplier_group->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select form-control" name="supplier_status_id" id="supplier_status_id" required>
                    <option value="" selected>--- Alege statusul furnizorului ---</option>
                    @foreach ($supplier_statuses as $supplier_status)
                        <option value="{{ $supplier_status->id }}">{{ $supplier_status->name }}</option>
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