<div class="modal fade" id="modalAddInventoryPlannerPrice" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Package</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="modal_add_price_type_id" class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_price_type_id" id="modal_add_price_type_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                    @foreach($price_types as $row)
                                        <option value="{{ $row->price_type_id }}">{{ $row->price_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_media_id" class="col-sm-2 control-label">Media</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_media_id" id="modal_add_media_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="modal_add_media_edition_id" class="col-sm-2 control-label">Edition No</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_media_edition_id" id="modal_add_media_edition_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label for="modal_add_advertise_position_id" class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_advertise_position_id" id="modal_add_advertise_position_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                    @foreach($advertise_positions as $row)
                                        <option value="{{ $row->advertise_position_id }}">{{ $row->advertise_position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_advertise_size_id" class="col-sm-2 control-label">Size</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_advertise_size_id" id="modal_add_advertise_size_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                    @foreach($advertise_sizes as $row)
                                        <option value="{{ $row->advertise_size_id }}">{{ $row->advertise_size_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_paper_id" class="col-sm-2 control-label">Paper Type</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_paper_id" id="modal_add_paper_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                    @foreach($papers as $row)
                                        <option value="{{ $row->paper_id }}">{{ $row->paper_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_advertise_rate_id" class="col-sm-2 control-label">Rate</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <select name="modal_add_advertise_rate_id" id="modal_add_advertise_rate_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value=""></option>
                                </select>
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_startdate" class="col-sm-2 control-label">Start Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_startdate" id="modal_add_inventory_planner_price_startdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('modal_add_inventory_planner_price_startdate') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_enddate" class="col-sm-2 control-label">End Date</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_enddate" id="modal_add_inventory_planner_price_enddate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('modal_add_inventory_planner_price_enddate') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_deadline" class="col-sm-2 control-label">Deadline</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_deadline" id="modal_add_inventory_planner_price_deadline" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('modal_add_inventory_planner_price_deadline') }}" autocomplete="off" data-mask="00/00/0000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_gross_rate" class="col-sm-2 control-label">Gross Rate</label>
                        <div class="col-sm-5">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_gross_rate" id="modal_add_inventory_planner_price_gross_rate" placeholder="Gross Rate" required="true" maxlength="20" value="{{ old('modal_add_inventory_planner_price_gross_rate') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                        <div class="col-sm-5">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_gross_rate_mask" id="modal_add_inventory_planner_price_gross_rate_mask" placeholder="" maxlength="20" value="" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_surcharge" class="col-sm-2 control-label">Surcharge (%)</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_surcharge" id="modal_add_inventory_planner_price_surcharge" placeholder="Surcharge" required="true" maxlength="3" value="{{ old('modal_add_inventory_planner_price_surcharge') }}" autocomplete="off" data-mask="000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_total_gross_rate" class="col-sm-2 control-label">Total Gross Rate</label>
                        <div class="col-sm-5">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_total_gross_rate" id="modal_add_inventory_planner_price_total_gross_rate" placeholder="Total Gross Rate" required="true" maxlength="20" value="{{ old('modal_add_inventory_planner_price_total_gross_rate') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                        <div class="col-sm-5">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_total_gross_rate_mask" id="modal_add_inventory_planner_price_total_gross_rate_mask" placeholder="" maxlength="20" value="" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_discount" class="col-sm-2 control-label">Discount (%)</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_discount" id="modal_add_inventory_planner_price_discount" placeholder="Discount" required="true" maxlength="3" value="{{ old('modal_add_inventory_planner_price_discount') }}" autocomplete="off" data-mask="000">
                            </div>
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_nett_rate" class="col-sm-2 control-label">Nett Rate</label>
                        <div class="col-sm-5">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_nett_rate" id="modal_add_inventory_planner_price_nett_rate" placeholder="Nett Rate" required="true" maxlength="20" value="{{ old('modal_add_inventory_planner_price_nett_rate') }}">
                            </div>
                            <small class="help-block"></small>
                        </div>
                        <div class="col-sm-5">
                            <div class="fg-line">
                                <input type="text" class="form-control input-sm input-mask" name="modal_add_inventory_planner_price_nett_rate_mask" id="modal_add_inventory_planner_price_nett_rate_mask" placeholder="" maxlength="20" value="" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modal_add_inventory_planner_price_remarks" class="col-sm-2 control-label">Remarks</label>
                        <div class="col-sm-10">
                            <div class="fg-line">
                                <textarea name="modal_add_inventory_planner_price_remarks" id="modal_add_inventory_planner_price_remarks" class="form-control input-sm" placeholder="Remarks">{{ old('modal_add_inventory_planner_price_remarks') }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect btn-add-inventory-planner-price">Save</button>
                <button type="button" class="btn btn-danger waves-effect btn-close-inventory-planner-price" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>