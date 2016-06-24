<div class="modal fade" id="modalAddClientContact" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Contact</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="client_name" class="col-sm-2 control-label">Client</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="hidden" name="client_id" value="">
                                <input type="text" class="form-control input-sm" name="client_name" id="client_name" placeholder="Client Name" required="true" maxlength="100" value="{{ old('client_name') }}" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_contact_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="client_contact_name" id="client_contact_name" placeholder="Contact Name" required="true" maxlength="100" value="{{ old('client_contact_name') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_contact_gender" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" name="client_contact_gender" value="1" {{ (old('client_contact_gender')=='1') ? 'checked' : '' }}>
                                        <i class="input-helper"></i>
                                        Male
                                    </label>
                                </div>
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" name="client_contact_gender" value="2" {{ (old('client_contact_gender')=='2') ? 'checked' : '' }}>
                                        <i class="input-helper"></i>
                                        Female
                                    </label>
                                </div>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_contact_birthdate" class="col-sm-2 control-label">Birth Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="client_contact_birthdate" id="client_contact_birthdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('client_contact_birthdate') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="religion_id" class="col-sm-2 control-label">Religion</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="religion_id" id="religion_id" class="chosen" required="true">
                                    <option value=""></option>
                                    @foreach ($religion as $row)
                                        {!! $selected = '' !!}
                                        @if($row->religion_id==old('religion_id'))
                                            {!! $selected = 'selected' !!}
                                        @endif
                                        <option value="{{ $row->religion_id }}" {{ $selected }}>{{ $row->religion_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_contact_position" class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="client_contact_position" id="client_contact_position" placeholder="Position" required="true" maxlength="100" value="{{ old('client_contact_position') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_contact_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="client_contact_email" id="client_contact_email" placeholder="Email" required="true" maxlength="100" value="{{ old('client_contact_email') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_contact_phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="client_contact_phone" id="client_contact_phone" placeholder="Phone" maxlength="15" value="{{ old('client_contact_phone') }}" required="true">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect btn-add-client-contact">Save</button>
                <button type="button" class="btn btn-danger waves-effect btn-close-client-contact" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditClientContact" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Contact</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="edit_client_name" class="col-sm-2 control-label">Client</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="hidden" name="edit_client_contact_id" value="">
                                <input type="text" class="form-control input-sm" name="edit_client_name" id="edit_client_name" placeholder="Client Name" required="true" maxlength="100" value="{{ old('client_name') }}" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_client_contact_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="edit_client_contact_name" id="edit_client_contact_name" placeholder="Contact Name" required="true" maxlength="100" value="{{ old('client_contact_name') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_client_contact_gender" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" name="edit_client_contact_gender" value="1" {{ (old('edit_client_contact_gender')=='1') ? 'checked' : '' }}>
                                        <i class="input-helper"></i>
                                        Male
                                    </label>
                                </div>
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" name="edit_client_contact_gender" value="2" {{ (old('edit_client_contact_gender')=='2') ? 'checked' : '' }}>
                                        <i class="input-helper"></i>
                                        Female
                                    </label>
                                </div>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_client_contact_birthdate" class="col-sm-2 control-label">Birth Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="edit_client_contact_birthdate" id="edit_client_contact_birthdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('client_contact_birthdate') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_religion_id" class="col-sm-2 control-label">Religion</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="edit_religion_id" id="edit_religion_id" class="chosen" required="true">
                                    <option value=""></option>
                                    @foreach ($religion as $row)
                                        {!! $selected = '' !!}
                                        @if($row->religion_id==old('edit_religion_id'))
                                            {!! $selected = 'selected' !!}
                                        @endif
                                        <option value="{{ $row->religion_id }}" {{ $selected }}>{{ $row->religion_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_client_contact_position" class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="edit_client_contact_position" id="edit_client_contact_position" placeholder="Position" required="true" maxlength="100" value="{{ old('client_contact_position') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_client_contact_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="edit_client_contact_email" id="edit_client_contact_email" placeholder="Email" required="true" maxlength="100" value="{{ old('client_contact_email') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_client_contact_phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm" name="edit_client_contact_phone" id="edit_client_contact_phone" placeholder="Phone" maxlength="15" value="{{ old('client_contact_phone') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect btn-edit-client-contact">Save</button>
                <button type="button" class="btn btn-danger waves-effect btn-close-client-contact-edit" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>