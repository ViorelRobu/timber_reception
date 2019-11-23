<!-- Modal -->
<div class="modal fade" id="recalculateFormMultiple" tabindex="-1" role="dialog" aria-labelledby="recalculateFormMultiple" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Recalculeaza date ambalaje pentru perioada
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/packaging/nir/recalculate/multiple" method="POST">
            @method('PATCH')
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
            <button type="submit" class="btn btn-primary">Continua</button>
        </form>
      </div>
    </div>
  </div>
</div>
