<div class="modal fade" id="new-service-modal" tabindex="-1" aria-labelledby="new-service-modalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-service-modalLabel">Add new service</h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            Hall features
                        </div>
                        <div class="col-sm-9">
                            One of three columns
                        </div>
                    </div>
                </div>
                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>

                    <div class="ms-auto p-2 bd-highlight">
                        <button type="submit" class="btn btn-warning">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="new-support-modal" tabindex="-1" aria-labelledby="new-support-modalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-support-modalLabel">New support ticket</h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
            </div>
            <form method="post" action="{{route('helps.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto" style="width: 29%;">
                            <label for="ticket-modal-title-field" class="col-form-label">Enter ticket title</label>
                        </div>
                        <div class="col-auto" style="width: 70%;">
                            <input name="title" type="text" id="ticket-modal-title-field" class="form-control"
                                   placeholder="Enter service name">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto" style="width: 29%; margin-top: -157px;">
                            <label for="ticket-modal-description-field" class="col-form-label">Issue description</label>
                        </div>
                        <div class="col-auto" style="width: 70%;">
                        <textarea rows="8" name="description" type="text" id="ticket-modal-description-field" class="form-control"
                                  placeholder="Enter service description"> </textarea>
                        </div>
                    </div>

                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto" style="margin-left: 9em;">
                            <button type="button" id="add-attachment-btn"
                                    class="btn btn-warning text-white text-center mx-auto" >
                                <img src="{{asset('assets/images/icons/attachment.png')}}" alt="..."> &nbsp; &nbsp;
                                &nbsp; &nbsp;Attach supporting document
                            </button>
                            <input name="attachments[]" id="support-attachments" type="file" multiple="multiple"
                                   class="d-none">
                        </div>
                    </div>
                    <div class="d-flex bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>

                        <div class="ms-auto p-2 bd-highlight">
                            <button type="submit" class="btn btn-warning">Save changes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

