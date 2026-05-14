<div class="table-responsive">
  <table id="pbio_detail_list" class="table table-striped table-bordered">
    <thead>
      <tr align="center">
        <th>{{ trans('cruds.bio.fields.id') }}</th>
        <th>{{ trans('cruds.bio.fields.customer_id') }}</th>
        <th>{{ trans('cruds.bio.fields.document_id') }}</th>
        <th>{{ trans('cruds.bio.fields.item_id') }}</th>
        <th>{{ trans('global.action') }}</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($pbio_details as $row)
        <tr id="tr_pbio_detail_id_{{ $row->id }}" class="showAnalystForm" data-id="{{ $row->id }}" data-customerid="{{ $row->customer_id }}" data-documentid="{{ $row->document_id }}">
          <td>
            {{ $row->id }}
          </td>
          <td>
            {{ $row->customer->name }}
          </td>
          <td>
            {{ $row->document_id }}
          </td>
          <td>
            @foreach ($row->details as $detail)
              {{ $detail->item->item_name }}
            @endforeach
          </td>
          <td>
            <div class="d-flex align-items-center gap-3 fs-6">
              @can($prefix.'show')
                <a id="showAnalystForm" data-id="{{ $row->id }}" data-customerid="{{ $row->customer_id }}" data-documentid="{{ $row->document_id }}" href="javascript:void(0)" class="text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-pencil-fill"></i></a>
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" align="center">No Bio Detail record Found</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
