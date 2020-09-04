<!-- Modal -->
<div class="modal fade" id="reactivateForm" tabindex="-1" role="dialog" aria-labelledby="reactivateForm" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title d-inline" id="exampleModalLongTitle">Reactiveaza reclamatia
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h3>
            </div>
            <div class="modal-body">
                <form action="/claims/reactivate" method="POST">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="reactivate_claim_id" id="reactivate_claim_id">
                        <p>Esti sigur ca vrei sa reactivezi reclamatia?</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
                        <button type="submit" class="btn btn-danger">Reactiveaza</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
