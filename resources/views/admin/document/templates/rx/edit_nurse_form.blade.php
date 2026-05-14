<div class="table-responsive">
  <table id="edit_nurse" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>{{ trans('cruds.rx_detail.fields.id') }}</th>
        <th>{{ trans('cruds.rx.fields.doctor_description') }}</th>
        <th>{{ trans('cruds.rx_detail.fields.result') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($nurses as $key => $nurse)
        <tr id="tr_object_id_{{ $nurse->id }}">
          <td>
            <div class="form-check">
              <input type="hidden" name="rx_id" id="rx_id" value="{{ $nurse->rx_id }}">
              <input checked id="rx_detail_id" name="rx_detail_id[]" data-id="{{ $nurse->id }}" class="form-check-input bio_item_name" type="checkbox" value="{{ $nurse->id }}">
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input readonly id="nuse_description-{{ $nurse->id }}" name="nuse_description[]" data-id="{{ $nurse->id }}" class="nuse_description form-control" type="text" placeholder="{{ trans('cruds.rx.fields.doctor_description') }}" value="{{ $nurse->description }}">
              <span class="text-danger error-text nuse_description_error"></span>
            </div>
          </td>
          <td>
            <div class="form-group mb-2">
              <input id="nurse_result-{{ $nurse->id }}" name="nurse_result[]" data-id="{{ $nurse->id }}" class="nurse_result form-control" type="text" placeholder="{{ trans('cruds.rx.fields.doctor_result') }}" value="{{ $nurse->result }}">
              <span class="text-danger error-text nurse_result_error"></span>
            </div>
          </td>
        </tr>
      @endforeach
      <tr>
        <th>{{ trans('cruds.rx_detail.fields.docfile') }}</th>
        <td colspan="2">
          <div class="form-group">
            <input id="docfile" name="docfile[]" class="form-control" type="file" multiple="">
            <span class="text-danger error-text docfile_error"></span>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class="row border">
  <label for="old_doc_file" class="mb-3"><b>Old Document Files</b></label>
  @foreach ($docfiles as $file)
    <?php
      $path_parts = pathinfo(public_path('uploads/rx/docfiles'.$file->filename));
    ?>
    <div class="col-lg-2 mb-3">
      @if (in_array($path_parts['extension'],array('jpeg','jpg','png','gif')))
        <a href="{{ asset('uploads/rx/docfiles/'.$file->filename) }}" rel="noopener noreferrer" target="_blank">
          <img src="{{ asset('uploads/rx/docfiles/'.$file->filename) }}" width="100%" height="100px">
        </a>
        {{ $file->filename }}
        <div class="d-flex justify-content-center mt-2">
          <a id="deleteObject" data-id="{{ $file->id }}" data-rx_id="{{ $file->rx_id }}" class="btn btn-sm btn-outline-danger" href="javascript:void(0)"><i class="fadeIn animated bx bx-trash-alt"></i> Delete</a>
        </div>
      @elseif (in_array($path_parts['extension'],array('csv','txt','pdf')))
        <a href="{{ route('admin.documents.pdfPreview',$file->id) }}" target="_blank" rel="noopener noreferrer">
          <img src="{{ asset('images/pdf-icon.png') }}" width="100%" height="100px">
        </a>
        {{ $file->filename }}
        <div class="d-flex justify-content-center mt-2">
          <a id="deleteObject" data-id="{{ $file->id }}" data-rx_id="{{ $file->rx_id }}" class="btn btn-sm btn-outline-danger" href="javascript:void(0)"><i class="fadeIn animated bx bx-trash-alt"></i> Delete</a>
        </div>
      @endif
    </div>
  @endforeach
</div>
