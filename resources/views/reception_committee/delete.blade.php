<!-- modal -->
<div class="modal fade" id="deleteSignature" tabindex="-1" role="dialog" aria-labelledby="deleteSignature" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Sterge semnatura
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
          Esti sigur ca vrei sa stergi semnatura?
      </div>
      <div class="modal-footer">
        <form action="" method="post">
            @csrf
            @method('PATCH')
            <input type="hidden" name="path" id="path" value="">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-danger">Sterge</button>
        </form>
      </div>
    </div>
  </div>
</div>
