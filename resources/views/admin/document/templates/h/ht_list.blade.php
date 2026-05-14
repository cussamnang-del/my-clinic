<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
  <div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered">
      <thead class="bg-success">
        <tr class="text-center">
          <th>{{ trans('cruds.ht.fields.h_time') }}</th>
          <th>{{ trans('cruds.ht.fields.product_id') }}</th>
          <th>{{ trans('cruds.ht.fields.qty') }}</th>
          <th>{{ trans('cruds.ht.fields.duration') }}</th>
          <th>{{ trans('global.action') }}</th>
        </tr>
      </thead>
      <tbody id="objectHospitalTreatment">
        @forelse ($hts as $key => $row)
          <tr id="tr_object_ht_id_{{ $row->id }}">
            <td>{{ $row->ht_date }} {{ date('H:i',strtotime($row->ht_time)) }}</td>
            <td>{{ $row->product->p_name }}
              @if ($row->htdetails->count()>0)(
                  @foreach ($row->htdetails as $key => $detail)
                    {{$detail->product->p_name}}({{$detail->qty}}),
                  @endforeach
                )
              @endif
            </td>
            <td>{{ $row->qty }}</td>
            <td>{{ $row->duration }}</td>
            <td>
              <div class="d-flex align-items-center gap-3 fs-6">
                @can($prefix.'show')
                  <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{ $row->id }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                @endcan
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="hiddenRow">
              @if ($row->htdetails->count()>0)
                <div class="accordian-body collapse" id="detail{{ $row->id }}">
                  <div class="table-responsive">
                    <table id="more_detail" class="table table-striped table-bordered">
                      <thead class="bg-secondary text-white">
                        <tr class="text-center">
                          <th>{{ trans('cruds.ht.fields.product_id') }}</th>
                          <th>{{ trans('cruds.ht.fields.qty') }}</th>
                        </tr>
                      </thead>
                      <tbody id="objectHTDetail">
                        @foreach ($row->htdetails as $detail)
                          <tr id="tr_object_htd_id_{{ $detail->id }}">
                            <td>{{ $detail->product->p_name }}</td>
                            <td>{{ $detail->qty }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">
              <h4 class="text-center">No record Found</h4>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
  <div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered">
      <thead class="bg-primary">
        <tr class="text-center">
           <th>{{ trans('cruds.hnote.fields.date') }}</th>
          <th>{{ trans('cruds.hnote.fields.mob') }}</th>
          <th>{{ trans('cruds.hnote.fields.dia') }}</th>
          <th>{{ trans('cruds.hnote.fields.todo') }}</th>
          <th>{{ trans('cruds.hnote.fields.comment') }}</th>
          {{-- <th>{{ trans('global.action') }}</th> --}}
        </tr>
      </thead>
      <tbody id="objectHnote">
        @forelse ($hnotes as $key => $row)
          <tr>
            <td>{{$row->date}}</td>
            <td>{{$row->mob}}</td>
            <td>{{$row->dia}}</td>
            <td>{{$row->todo}}</td>
            <td>{{$row->comment}}</td>
            {{-- <td>
              <div class="d-flex align-items-center gap-3 fs-6">
                @can($prefix.'show')
                  <a id="hnoteShow" data-bs-toggle="collapse" data-bs-target="#detail{{ $key }}" class="accordion-toggle hnoteShow text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                @endcan
              </div>
            </td> --}}
          </tr>
        @empty
          <tr>
            <td colspan="5">
              <h4 class="text-center">No record Found</h4>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
