<!-- Modal -->
<div class="modal fade" id="nirForm" tabindex="-1" role="dialog" aria-labelledby="countriesForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga NIR
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/nir/add" method="POST">
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
                        <input type="text" class="form-control pull-right" id="data_nir" name="data_nir" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" id="numar_we" name="numar_we" placeholder="Numar WE">
                </div>
                <div class="form-group col-md-12">
                    <select class="custom-select form-control" name="supplier_id" id="supplier_id" required>
                        <option value="" selected>--- Alege furnizorul ---</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                        <input type="text" class="form-control pull-right" id="data_dvi" name="data_dvi" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="greutate_bruta" name="greutate_bruta" placeholder="Greutate bruta">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="greutate_neta" name="greutate_neta" placeholder="Greutate neta">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="serie_aviz" name="serie_aviz" placeholder="Serie aviz" required>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="numar_aviz" name="numar_aviz" placeholder="Numar aviz" required>
                </div>
                <div class="form-group col-md-4">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="data_aviz" name="data_aviz" data-provide="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off">
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
                {{-- <div class="details d-flex flex-row">
                    <div class="group-nir">
                        <div class="form-group col-md-5">
                            <input type="text" class="form-control" id="test1" name="test1[]" placeholder="Test 1">
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" class="form-control" id="test2" name="test2[]" placeholder="Test 2">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="button" class="addBtn btn btn-secondary">Adauga</button>
                    </div>
                </div> --}}
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