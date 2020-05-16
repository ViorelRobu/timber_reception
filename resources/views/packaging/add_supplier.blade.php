<!-- Modal -->
<div class="modal fade" id="addSupplierForm" tabindex="-1" role="dialog" aria-labelledby="addSupplierForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga greutate
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/packaging/supplier/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="company_id" id="company_id" value="{{ session()->get('company_was_selected') }}">
            <div class="form-group">
                <select class="form-control" name="subsupplier_id" id="supplier_id" required>
                        <option value="" selected>-- Selecteaza furnizorul --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="subgroup_id" id="subgroup_id" required>
                        <option value="" selected>-- Selecteaza grupa --</option>
                    @foreach ($subgroups as $subgroup)
                        <option value="{{ $subgroup->id }}">{{ $subgroup->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="unitate" id="unitate" required>
                        <option value="" selected>-- Selecteaza unitatea --</option>
                        <option value="metri liniari">Metri liniari</option>
                        <option value="metri cubi">Metri cubi</option>
                        <option value="pachet">Numar pachete</option>
                </select>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" step="0.001" id="greutate" name="greutate" placeholder="Greutate (kg)" required>
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
