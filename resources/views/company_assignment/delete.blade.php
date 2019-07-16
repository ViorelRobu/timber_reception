<!-- Modal -->
<div class="modal fade" id="deleteAccessRights" tabindex="-1" role="dialog" aria-labelledby="deleteAccessRights" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Elimina drepturi de acces
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form id="deleteForm" action="/companies/assign/delete" method="POST">
            @method('DELETE')
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
            Esti sigur ca vrei sa elimini drepturile de acces ale acestui utilizator?
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
            <button type="submit" class="btn btn-danger">Sunt sigur! Elimina!</button>
        </form>
      </div>
    </div>
  </div>
</div>