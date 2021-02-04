<!-- Modal -->
<div class="modal fade" id="nirForm" tabindex="-1" role="dialog" aria-labelledby="countriesForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Editeaza NIR
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="company_id" id="company_id" value="{{ session()->get('company_was_selected') }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="numar_nir" name="numar_nir" placeholder="Numar NIR" required>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="data_nir" name="data_nir" placeholder="Data NIR" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" id="numar_we" name="numar_we" placeholder="Numar WE">
                </div>
                <div class="form-group col-md-8">
                    <select class="custom-select form-control" name="supplier_id" id="supplier_id" onchange="loadSubSupplier(this.value, '#edit_subsupplier_id')" required>
                        <option value="" selected>--- Alege furnizorul ---</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="custom-select form-control" name="committee_id" id="committee_id" required>
                        @if ($committee_list->count() == 1)
                            @foreach ($committee_list as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>--- Alege fluxul ---</option>
                            @foreach ($committee_list as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <select class="custom-select form-control" name="subsupplier_id" id="edit_subsupplier_id" required>
                        <option value="" selected>--- Alege subfurnizorul ---</option>
                        @foreach ($subsuppliers as $subsupplier)
                            <option value="{{ $subsupplier->id }}">{{ $subsupplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="dvi" name="dvi" placeholder="DVI">
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="data_dvi" name="data_dvi" placeholder="Data DVI" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <input type="number" class="form-control" id="greutate_bruta" step="0.01" min="0" name="greutate_bruta" placeholder="Greutate bruta">
                </div>
                <div class="form-group col-md-6">
                    <input type="number" class="form-control" id="greutate_neta" step="0.01" min="0" name="greutate_neta" placeholder="Greutate neta">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="serie_aviz" name="serie_aviz" placeholder="Serie aviz">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="numar_aviz" name="numar_aviz" placeholder="Numar aviz">
                </div>
                <div class="form-group col-md-4">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="data_aviz" name="data_aviz" placeholder="Data aviz" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="specificatie" name="specificatie" placeholder="Specificatie">
                </div>
                <div class="form-group col-md-6">
                    <select class="custom-select form-control" name="certification_id" id="certification_id" required>
                        <option value="" selected>--- Alege certificarea ---</option>
                        @foreach ($certifications as $certification)
                            <option value="{{ $certification->id }}">{{ $certification->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="custom-select form-control" name="vehicle_id" id="vehicle_id" required>
                        <option value="" selected>--- Mijloc transport ---</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <input type="text" class="form-control" id="numar_inmatriculare" name="numar_inmatriculare" placeholder="Numar inmatriculare" required>
                </div>
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
