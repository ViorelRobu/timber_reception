<!-- Modal -->
<div class="modal fade" id="supplierForm" tabindex="-1" role="dialog" aria-labelledby="supplierForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga subfurnizor
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/sub_suppliers/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
                <select class="custom-select form-control" name="supplier_id" id="supplier_id" required>
                    <option value="" selected>--- Alege furnizorul ---</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Denumire subfurnizor" required>
            </div>
            <div class="form-group">
                <select class="custom-select form-control" name="country_id" id="country_id" required>
                    <option value="" selected>--- Alege tara de rezidenta ---</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
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
