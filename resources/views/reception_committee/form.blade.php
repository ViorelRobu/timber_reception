<!-- modal -->
<div class="modal fade" id="receptionCommitteeForm" tabindex="-1" role="dialog" aria-labelledby="receptionCommitteeForm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title d-inline" id="exampleModalLongTitle">Adauga membru nou la comisia de receptie
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </h3>
      </div>
      <div class="modal-body">
        <form action="/reception/add/member" method="POST">
            @method('POST')
            @csrf
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
                <select class="form-control" name="committee_id" id="committee_id">
                  @foreach ($committee_list as $committee)
                    <option value="{{ $committee->id }}">{{ $committee->name }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="member" id="member" placeholder="Nume membru" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="active" id="active">
                    <option value="1" selected>Activ</option>
                    <option value="0">Inactiv</option>
                </select>
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
