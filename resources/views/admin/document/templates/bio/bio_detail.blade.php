@if ($bios->count()>0)
  <thead class="bg-dark text-white">
    <tr align="center">
      <th>{{ trans('cruds.bio.fields.id') }}</th>
      <th>{{ trans('cruds.bio.fields.item_id') }}</th>
      <th>{{ trans('cruds.bio.fields.normal_value') }}</th>
      <?php
        $items = DB::table('bio_details')->select('bio_date')->distinct()->orderBy('bio_date','desc')->get();
      ?>
      @foreach ($items as $item)
      <?php
        $datas[] = $item->bio_date;
      ?>
        <th class="text-center">{{ date('d-m-Y',strtotime($item->bio_date)) }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    <?php
      $i=0;
    ?>
    @foreach ($bios as $row)
      <tr id="tr_object_id_{{ $row->id }}">
        <td>{{ $row->id }}</td>
        <td>{{ $row->item->item_name }}</td>
        <td>100g</td>
        @foreach ($row->detail as $key => $item)
          @foreach ($datas as $key1 => $date)
            @if ($key1 >= $i)
              @if ($item->bio_date === $date)
                <?php
                  $i=$key1+1;
                ?>
                <td>
                  @if ($item->bio_result < $row->item->min_value || $item->bio_result > $row->item->max_value)
                    <strong>{{ $item->bio_result }}</strong>
                  @else
                    {{ $item->bio_result }}
                  @endif
                </td>
                @break
              @else
                <td></td>
              @endif
            @endif
          @endforeach
        @endforeach
      </tr>
      <?php
        $i=0;
      ?>
    @endforeach
  </tbody>
@else
<thead>
  <tr class="text-center">
    <td colspan="4"> No Bio Result Found</td>
  </tr>
</thead>
@endif
