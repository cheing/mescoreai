<!-- Winner Selection Modal -->
<div class="modal fade" id="ModalWinner" tabindex="-1" role="dialog" aria-labelledby="ModalWinnerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalWinnerLabel">Select Winner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="winnerForm">
                    <div class="form-group">
                        <label for="winnerSelect">Winner</label>
                        <select class="form-control" id="winnerSelect" name="winner_id">
                            <!-- Options will be added dynamically -->
                        </select>
                    </div>
                    <button type="button" id="buttonWinnerSubmit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
