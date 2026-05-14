<div class="modal fade" id="addNewTreatmentObjectModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="addNewTreatmentObjectModal">
    <div class="modal-dialog modal-xl modal-center">
        <div class="modal-content">
            <form id="frmAddHospitalTreatment" action="{{ route('admin.' . $crudRoutePath . '.storeObjectHT') }}"
                method="post">
                {{ csrf_field() }}
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Add Hospital Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ht_customer_id" name="ht_customer_id">
                    <input type="hidden" id="ht_document_id" name="ht_document_id">
                    <input type="hidden" id="htd_hospital_id" name="htd_hospital_id">
                    <input type="hidden" id="htd_hospital_treatment_id" name="htd_hospital_treatment_id">
                    <input type="hidden" id="htd_hospital_treatment_product_id"
                        name="htd_hospital_treatment_product_id">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-2">
                                        <label for="ht_time"
                                            class="form-control-label mb-2">{{ trans('cruds.ht.fields.h_time') }}:<span
                                                class="text-danger">*</span></label>
                                        <input id="ht_time" name="ht_time" class="form-control" type="text"
                                            placeholder="{{ trans('cruds.ht.fields.h_time') }}">
                                        <span class="text-danger error-text ht_time_error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-2">
                                        <label for="duration"
                                            class="form-control-label mb-2">{{ trans('cruds.ht.fields.duration') }}:<span
                                                class="text-danger">*</span></label>
                                        <input id="duration" name="duration" class="form-control" type="text"
                                            placeholder="{{ trans('cruds.ht.fields.duration') }}">
                                        <span class="text-danger error-text duration_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="product_id"
                                            class="form-control-label mb-2">{{ trans('cruds.ht.fields.product_id') }}:
                                            <span class="text-danger">*</span></label>
                                        <input type="text" data-id="product_id_1" data-type="p_name"
                                            id="product_id_1" name="product_id"
                                            class="product_id form-control autocomplete_product_id"
                                            placeholder="{{ trans('cruds.ht.fields.product_id') }}" autocomplete="off">
                                        <span class="text-danger error-text product_id_error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mb-2">
                                        <label for="qty"
                                            class="form-control-label mb-2">{{ trans('cruds.ht.fields.qty') }}:<span
                                                class="text-danger">*</span></label>
                                        <input id="qty" name="qty" class="form-control" type="text"
                                            placeholder="{{ trans('cruds.ht.fields.qty') }}">
                                        <span class="text-danger error-text qty_error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mb-2">
                                        <label for="ht_how_to_use"
                                            class="form-control-label mb-2">{{ trans('cruds.ht.fields.how_to_use') }}:<span
                                                class="text-danger">*</span></label>
                                        {{-- <input id="ht_how_to_use" name="ht_how_to_use" class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}"> --}}
                                        <input list="how_to_uses" id="ht_how_to_use" name="ht_how_to_use"
                                            class="form-control" type="text"
                                            placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                                        <span class="text-danger error-text ht_how_to_use_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3">
                                    <div class="form-group mt-1">
                                        <div class="form-check form-switch">
                                            <input id="status" name="status" class="form-check-input"
                                                type="checkbox" checked>
                                            <label class="form-check-label mt-1"
                                                for="flexSwitchCheckChecked">&nbsp;&nbsp;{{ trans('global.status') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- add more product section --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset class="form-group p-3">
                                        <legend class="w-auto px-2"><a href="javascript:void(0)">Additional</a>
                                        </legend>
                                        <div class="field_wrapper">
                                            <div class="mb-2 p_count" id="no-delete">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="more_product"
                                                                class="form-control-label mb-2">{{ trans('cruds.ht.fields.product_id') }}:</label>
                                                            <input type="text" data-id="more_product_1"
                                                                data-type="p_name" id="more_product_1"
                                                                name="more_product[]"
                                                                class="more_product form-control autocomplete_more_product"
                                                                placeholder="{{ trans('cruds.ht.fields.product_id') }}"
                                                                autocomplete="off">
                                                            <span
                                                                class="text-danger error-text more_product_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group mb-2">
                                                            <label for="more_qty"
                                                                class="form-control-label mb-2">{{ trans('cruds.ht.fields.qty') }}:</label>
                                                            <input id="more_qty" name="more_qty[]"
                                                                class="form-control" type="text"
                                                                placeholder="{{ trans('cruds.ht.fields.qty') }}">
                                                            <span class="text-danger error-text more_qty_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group mb-2">
                                                            <label for="more_how_to_use"
                                                                class="form-control-label mb-2">{{ trans('cruds.ht.fields.how_to_use') }}:</label>
                                                            {{-- <input id="more_how_to_use" name="more_how_to_use[]" class="form-control" type="text" placeholder="{{ trans('cruds.ht.fields.how_to_use') }}"> --}}
                                                            <input list="how_to_uses" id="more_how_to_use"
                                                                name="more_how_to_use[]" class="form-control"
                                                                type="text"
                                                                placeholder="{{ trans('cruds.ht.fields.how_to_use') }}">
                                                            <span
                                                                class="text-danger error-text more_how_to_use_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mt-4">
                                                        <label for="">&nbsp;</label>
                                                        <button type="button"
                                                            class="btn btn-sm btn-success mt-2 add_more_treatment"><i
                                                                class="fadeIn animated bx bx-plus-medical"></i>
                                                            Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @include('admin.templates.button')
                </div>
            </form>
        </div>
    </div>
</div>
