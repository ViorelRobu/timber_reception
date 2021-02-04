<!-- Modal -->
<div class="modal fade" id="nirDetailsForm" tabindex="-1" role="dialog" aria-labelledby="nirDetailsForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga detalii
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
    <div class="modal-body">
        <form action="/nir/details/add" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="nir_id" id="nir_id" value="{{ $nir->id }}">
            <div class="details d-flex flex-row">
                <div class="group-nir">
                    <div class="form-group col-md-4">
                        <select class="custom-select form-control" name="article_id" id="article_id" required>
                            <option value="" selected>--- Articol ---</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}">{{ $article->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select class="custom-select form-control" name="species_id" id="species_id" required>
                            <option value="" selected>--- Specie ---</option>
                            @foreach ($species as $species)
                                <option value="{{ $species->id }}">{{ $species->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select class="custom-select form-control" name="moisture_id" id="moisture_id" required>
                            <option value="" selected>--- Grup ---</option>
                            @foreach ($moistures as $moisture)
                                <option value="{{ $moisture->id }}">{{ $moisture->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" id="volum_aviz"  step="0.000001"name="volum_aviz" placeholder="Volum aviz" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" id="volum_receptionat" step="0.001" name="volum_receptionat" placeholder="Volum factura" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" id="pachete" name="pachete" placeholder="Numar pachete" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" id="total_ml" step="0.01"name="total_ml" placeholder="Total lungimi pachete" required>
                    </div>
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
