<thead>
  @foreach ($typeB as $key => $row)
    <tr>
      <th>{{ $row->lifesign->name }}</th>
      <td>
        <a id="editLifeSign" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)">
          {{ $row->coldesr }}&nbsp;({{ $row->col_measure }})&nbsp;({{$row->coltime}})
        </a>
      </td>
      <td width="30px">
        <a id="objectDocLifeAdd" data-id="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add New" aria-label="Add">
          <i class="bi bi-plus-circle-fill"></i>
        </a>
        <a id="objectDetailB" data-bs-toggle="collapse" data-bs-target="#detailB{{ $key }}" class="accordion-toggle objectShow {{ $row->colFields->count()>0? 'text-primary':'text-secondary' }}"
          data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->colFields->count()>0?'pointer;':'default;' }}"
          data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i>
        </a>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="hiddenRow">
        @if ($row->colFields->count()>0)
        <div class="accordian-body collapse" id="detailB{{ $key }}">
          <div class="table-responsive">
            <table id="more_detail" class="table table-striped table-bordered">
              <thead class="bg-secondary text-white">
                <tr class="text-center">
                  <th>{{ trans('cruds.document_life.fields.coltype') }}</th>
                  <th>{{ trans('cruds.document_life_detail.fields.coldesr') }}</th>
                  <th>{{ trans('cruds.document_life_detail.fields.coldate') }}</th>
                  <th>{{ trans('global.action') }}</th>
                </tr>
              </thead>
              <tbody id="objectTypeDetail">
                @foreach ($row->colFields as $key => $detail)
                  <tr id="tr_object_type_id_{{ $detail->id }}">
                    <td>{{ $row->lifesign->name }}}</td>
                    <td>{{ $detail->coldesr }}&nbsp;({{ $detail->col_measure }}) ({{$detail->coltime}})</td>
                    <td>{{ $detail->coldate }}</td>
                    <td width="30px" align="center">
                      <a id="objectDocLifeEdit" data-id="{{ $detail->id }}" data-lifeid="{{ $row->id }}" data-lifetype="{{ $row->lifesign->name }}" href="javascript:void(0)" style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
      </td>
    </tr>
  @endforeach
</thead>
