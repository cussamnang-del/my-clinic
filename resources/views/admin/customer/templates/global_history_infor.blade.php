<div class="col-xl-12">
  <div class="row">
    <div class="col-xl-2">
      <div class="nav flex-column nav-pills mb-3">
        <a href="#v-pills-bio" data-bs-toggle="pill" class="nav-link active show">BIO</a>
        <a href="#v-pills-rx" data-bs-toggle="pill" class="nav-link">RX</a>
        <a href="#v-pills-h" data-bs-toggle="pill" class="nav-link">HOSPITAL</a>
        <a href="#v-pills-ht" data-bs-toggle="pill" class="nav-link">HOSPITAL TREATMENT</a>
        <a href="#v-pills-order" data-bs-toggle="pill" class="nav-link">ORDER</a>
      </div>
    </div>
    <div class="col-xl-10">
      <div class="tab-content">
        <div id="v-pills-bio" class="tab-pane fade active show">
          <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
                <thead class="bg-primary text-white">
                  <tr>
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
                  @forelse ($bios as $row)
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
                  @empty
                    <tr>
                      <td colspan="{{ $items->count()+3 }}">
                        <h4 class="text-center">No record Found</h4>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
          </div>
        </div>
        <div id="v-pills-rx" class="tab-pane fade">
          <div class="table-responsive">
            <table id="rx_detail_list" class="table table-striped table-bordered">
              <thead class="bg-secondary text-white">
                <tr>
                  <th>{{ trans('cruds.rx.fields.id') }}</th>
                  <th>{{ trans('cruds.rx.fields.rx_date') }}</th>
                  <th>{{ trans('cruds.customer.title_singular') }}</th>
                  <th>{{ trans('cruds.document.title_singular') }}</th>
                  <th>{{ trans('cruds.rx.fields.doctor_description') }}</th>
                  <th>{{ trans('global.action') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($rx_details as $rx)
                  <tr id="tr_object_id_{{ $rx->id }}">
                    <td>
                      {{ $rx->id }}
                    </td>
                    <td>
                      {{ date('d-m-Y',strtotime($rx->rx_date)) }}
                    </td>
                    <td>
                      {{ $rx->customer->name }}
                    </td>
                    <td>
                      {{ $rx->document_id }}
                    </td>
                    <td>
                      {{ $rx->rx_note }}
                    </td>
                    <td>
                      <div class="d-flex align-items-center gap-3 fs-6">
                        @can($prefix.'show')
                          <a href="javascript:void(0)" id="showRxDetail" data-id="{{ $rx->id }}" data-customer_id="{{ $rx->customer_id }}" data-document_id="{{ $rx->document_id }}" href="{{ route('admin.'.$crudRoutePath.'.showHistory') }}" class="showRxDetail text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Show Rx Detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">
                      <h4 class="text-center">No record Found</h4>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div id="v-pills-h" class="tab-pane fade">
          <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
              <thead class="bg-info">
                <tr class="text-center">
                  <th>{{ trans('cruds.hospital.fields.id') }}</th>
                  <th>{{ trans('cruds.hospital.fields.room_no') }}</th>
                  <th>{{ trans('cruds.hospital.fields.h_date') }}</th>
                  <th>{{ trans('cruds.hospital.fields.h_note') }}</th>
                </tr>
              </thead>
              <tbody id="objectHospital">
                @forelse ($hospitals as $key => $row)
                  <tr id="tr_object_ht_id_{{ $row->id }}">
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->room->room_no }}</td>
                    <td>{{ $row->h_date }}</td>
                    <td>{{ $row->h_note }}</td>
                  </tr>
                  @empty
                    <tr>
                      <td colspan="4">
                        <h4 class="text-center">No record Found</h4>
                      </td>
                    </tr>
                  @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div id="v-pills-ht" class="tab-pane fade">
          <div class="row">
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
                    @forelse ($hospital_treatments as $key => $row)
                      <tr id="tr_object_ht_id_{{ $row->id }}">
                        <td>{{ $row->ht_time }}</td>
                        <td>{{ $row->product->p_name }}
                          @if ($row->htdetails->count()>0)
                            (
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
                              <a id="objectShow" data-bs-toggle="collapse" data-bs-target="#detail{{ $key }}" class="accordion-toggle objectShow {{ $row->htdetails->count()>0? 'text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: {{ $row->htdetails->count()>0?'pointer;':'default;' }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            @endcan
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" class="hiddenRow">
                          @if ($row->htdetails->count()>0)
                            <div class="accordian-body collapse" id="detail{{ $key }}">
                              <div class="table-responsive">
                                <table id="more_detail" class="table table-striped table-bordered">
                                  <thead class="bg-secondary text-white">
                                    <tr class="text-center">
                                      <th>{{ trans('cruds.ht.fields.product_id') }}</th>
                                      <th>{{ trans('cruds.ht.fields.qty') }}</th>
                                    </tr>
                                  </thead>
                                  <tbody id="objectHTDetail">
                                    @foreach ($row->htdetails as $key => $detail)
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
                      <th>{{ trans('global.action') }}</th>
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
                        <td>
                          <div class="d-flex align-items-center gap-3 fs-6">
                            @can($prefix.'show')
                              <a id="hnoteShow" data-bs-toggle="collapse" data-bs-target="#detail{{ $key }}" class="accordion-toggle hnoteShow text-primary':'text-secondary' }}" data-id="{{ $row->id }}" href="javascript:void(0)" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            @endcan
                          </div>
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
          </div>
        </div>
        <div id="v-pills-order" class="tab-pane fade">
          <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
              <thead class="bg-warning">
                <tr>
                  <th>{{ trans('cruds.order.fields.id') }}</th>
                  <th>{{ trans('cruds.order.fields.order_type') }}</th>
                  <th>{{ trans('cruds.order.fields.customer_id') }}</th>
                  <th>{{ trans('cruds.order.fields.order_date') }}</th>
                  <th>{{ trans('cruds.order.fields.user_id') }}</th>
                  <th>{{ trans('cruds.customer.fields.age') }}</th>
                  <th>{{ trans('cruds.customer.fields.sex') }}</th>
                  <th>{{ trans('global.action') }}</th>
                </tr>
              </thead>
              <tbody id="objectOrder">
                @forelse ($orders as $order)
                  <tr id="tr_object_id_{{ $order->id }}">
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->order_type }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ date('d-M-Y',strtotime($order->order_date)) }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->customer->sex }}</td>
                    <td>{{ $order->customer->age }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-3 fs-6">
                        @can($prefix.'show')
                          <a id="objectShow" data-id="{{ $order->id }}" href="{{ route('admin.'.$crudRoutePath.'.previewReceipt',$order->id) }}" target="_blank" class="objectShow text-primary" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Preview Report" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        @endcan
                      </div>
                    </td>
                  </tr>
                  @empty
                    <tr>
                      <td colspan="8">
                        <h4 class="text-center">No record Found</h4>
                      </td>
                    </tr>
                  @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
