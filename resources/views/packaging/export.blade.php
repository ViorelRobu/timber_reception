<!-- Modal -->
<div class="modal fade" id="exportPackaging" tabindex="-1" role="dialog" aria-labelledby="exportPackaging" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Exporta date ambalaj pentru perioada
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/packaging/nir/export" method="POST">
            @method('POST')
            @csrf
             <div class="form-group col-md-6">
                <input type="text" class="form-control" id="from" name="from" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data inceput" autocomplete="off">
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="to" name="to" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Data final" autocomplete="off">
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-primary">Descarca raport</button>
        </form>
      </div>
    </div>
  </div>
</div>
