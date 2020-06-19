<!-- Modal -->
<div class="modal fade" id="deleteClaimForm" tabindex="-1" role="dialog" aria-labelledby="deleteClaimForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Sterge reclamatie
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            @method('DELETE')
            @csrf
            Esti sigur ca vrei sa stergi reclamatia?
          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
                <button type="submit" class="btn btn-danger">Sterge</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
