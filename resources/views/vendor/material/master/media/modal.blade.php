<div class="modal fade" id="modalAddMediaEdition" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Media Edition</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="media_name" class="col-sm-2 control-label">Media</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="hidden" name="media_id" value="">
                                <input type="text" class="form-control input-sm" name="media_name" id="media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ old('media_name') }}" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="media_edition_no" class="col-sm-2 control-label">Edition No</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="media_edition_no" id="media_edition_no" placeholder="Edition No" required="true" maxlength="50" value="{{ old('media_edition_no') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="media_edition_publish_date" class="col-sm-2 control-label">Publish Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="media_edition_publish_date" id="media_edition_publish_date" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('media_edition_publish_date') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="media_edition_deadline_date" class="col-sm-2 control-label">Deadline Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="media_edition_deadline_date" id="media_edition_deadline_date" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('media_edition_deadline_date') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="media_edition_desc" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <textarea name="media_edition_desc" id="media_edition_desc" class="form-control input-sm" placeholder="Description">{{ old('media_edition_desc') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect btn-add-media-edition">Save</button>
                <button type="button" class="btn btn-danger waves-effect btn-close-media-edition" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditMediaEdition" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Media Edition</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="edit_media_name" class="col-sm-2 control-label">Media</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="hidden" name="edit_media_edition_id" value="">
                                <input type="text" class="form-control input-sm" name="edit_media_name" id="edit_media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ old('media_name') }}" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_media_edition_no" class="col-sm-2 control-label">Edition No</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="edit_media_edition_no" id="edit_media_edition_no" placeholder="Edition No" required="true" maxlength="50" value="{{ old('media_edition_no') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_media_edition_publish_date" class="col-sm-2 control-label">Publish Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="edit_media_edition_publish_date" id="edit_media_edition_publish_date" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('media_edition_publish_date') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_media_edition_deadline_date" class="col-sm-2 control-label">Deadline Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="edit_media_edition_deadline_date" id="edit_media_edition_deadline_date" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('media_edition_deadline_date') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_media_edition_desc" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <textarea name="edit_media_edition_desc" id="edit_media_edition_desc" class="form-control input-sm" placeholder="Description">{{ old('media_edition_desc') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect btn-edit-media-edition">Save</button>
                <button type="button" class="btn btn-danger waves-effect btn-close-media-edition-edit" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>