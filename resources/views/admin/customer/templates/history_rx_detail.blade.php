<div class="row">
  <div class="col-xl col-lg-12 col-md-12">
    <div class="table-responsive">
      <table id="history_detail" class="table table-striped table-bordered history_detail">
        <thead class="bg-info">
          <th>Description</th>
          <th>Result</th>
        </thead>
        <tbody>
          @foreach ($rx_details as $row)
            <tr>
              <th>{{ $row->description }}</th>
              <th>{{ $row->result }}</th>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-xl col-lg-12 col-md-12">
    <div class="row">
      @foreach ($rx_files as $file)
      <?php
        $path_parts = pathinfo(public_path('uploads/rx/docfiles'.$file->filename));
      ?>
        <div class="col-lg-2">
          @if (in_array($path_parts['extension'],array('jpeg','jpg','png','gif')))
            <a href="{{ asset('uploads/rx/docfiles/'.$file->filename) }}" rel="noopener noreferrer" target="_blank">
              {{-- <img src="{{ asset('images/image-icon.png') }}" width="100%" height="180px"> --}}
              <img src="{{ asset('uploads/rx/docfiles/'.$file->filename) }}" width="100%" height="120px">
            </a>
            {{ $file->filename }}
          @elseif (in_array($path_parts['extension'],array('csv','txt','pdf')))
            <a href="{{ route('admin.documents.pdfPreview',$file->id) }}" target="_blank" rel="noopener noreferrer">
              <img src="{{ asset('images/pdf-icon.png') }}" width="100%" height="120px">
            </a>
            {{ $file->filename }}
          @endif
        </div>
      @endforeach
    </div>
  </div>
</div>
