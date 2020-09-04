<!-- Modal -->
<div class="modal fade" id="changeStatusForm" tabindex="-1" role="dialog" aria-labelledby="changeStatusForm" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changeStatForm" action="" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="claim_status_id">Status reclamatie</label>
                        <select class="form-control" name="claim_status_id" id="claim_status_id">
                            @foreach($status as $stat)
                                <option value="{{ $stat->id }}">{{ $stat->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="resolution">Rezolvare</label>
                        <input type="text"
                            class="form-control" name="resolution" id="resolution" placeholder="Rezolvare">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
                        <button type="submit" class="btn btn-primary">Salveaza</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
