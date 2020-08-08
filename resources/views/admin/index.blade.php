@extends('layouts.admin')

@section('content')
    @include('layouts.admin.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1"> {{ __('admin.overview') }}</h6>
                                <h2 class="text-white mb-0">{{ __('admin.total_sales') }}</h2>
                            </div>
                            <div class="col">
                                <div class="dropdown float-right">
                                    <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('admin.filter') }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="{{url('/admin?sales=last_week')}}">{{ __('admin.last_week') }}</a>
                                      <a class="dropdown-item" href="{{url('/admin?sales=last_month')}}">{{ __('admin.last_month') }}</a>
                                      <a class="dropdown-item" href="{{url('/admin?sales=last_year')}}">{{ __('admin.last_year') }}</a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-sales" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">{{ __('admin.performance') }}</h6>
                                <h2 class="mb-0">{{ __('admin.sales_by_type') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-orders" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('admin.partner_requests') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive  p-4">
                        <!-- Projects table -->
                        <table id="partnership-table" class="table align-items-center table-flush data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('partners.business_name') }}</th>
                                    <th>{{ __('auth.first_name') }}</th>
                                    <th>{{ __('auth.name') }}</th>
                                    <th>{{ __('auth.email') }}</th>
                                    <th>{{ __('auth.home_phone') }}</th>
                                    <th>{{ __('auth.mobile_phone') }}</th>
                                    <th>{{ __('auth.city') }}</th>
                                    <th>{{ __('auth.province') }}</th>
                                    <th>{{ __('auth.postal_code') }}</th>
                                    <th width="100px">{{ __('admin.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('admin.partner_history') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-4">
                        <!-- Projects table -->
                        <table id="history-table" class="table align-items-center table-flush data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('partners.business_name') }}</th>
                                    <th>{{ __('auth.first_name') }}</th>
                                    <th>{{ __('auth.name') }}</th>
                                    <th>{{ __('auth.email') }}</th>
                                    <th>{{ __('auth.home_phone') }}</th>
                                    <th>{{ __('auth.mobile_phone') }}</th>
                                    <th>{{ __('auth.city') }}</th>
                                    <th>{{ __('auth.province') }}</th>
                                    <th>{{ __('auth.postal_code') }}</th>
                                    <th width="100px">{{ __('admin.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('admin.partner_sales_data') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-4">
                        <!-- Projects table -->
                        <table id="partner-sales-table" class="table align-items-center table-flush data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('partners.business_name') }}</th>
                                    <th>{{ __('auth.first_name') }}</th>
                                    <th>{{ __('auth.name') }}</th>
                                    <th>{{ __('auth.email') }}</th>
                                    <th>{{ __('admin.promocode') }}</th>
                                    <th>{{ __('admin.promocode_value') }}</th>
                                    <th>{{ __('admin.promocode_usage') }}</th>
                                    <th>{{ __('admin.total_referrals') }}</th>
                                    <th>{{ __('admin.total_sales') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="approve-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">{{ __('admin.promocode_option') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form id="voucher-form" method="POST" action="{{ url("partners/approve") }}">
                        @csrf
                        <input type="hidden" class="form-control" id="partner_id" name="partner_id">
                        {{-- <div class="form-group">
                            <label for="promocode" class="col-form-label">Promocode</label>
                            <input type="text" class="form-control" id="promocode" name="promocode">
                        </div> --}}
                        <label for="discount_value" class="col-form-label">{{ __('admin.promocode_value') }}</label>
                        <div class="form-group">
                            <div class="row">
                                <div class="input-group mb-3 col-md-5">
                                    <div class="input-group-prepend">
                                       
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" name="discount_value">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <p> or </p>
                                </div>
                                
                                <div class="input-group mb-3 col-md-5">
                                    <input type="number" class="form-control" name="discount_percent">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.close') }}</button>
                  <button type="button" id="submit-form" class="btn btn-primary">{{ __('admin.submit') }}</button>
                </div>
              </div>
            </div>
          </div>

        @include('layouts.admin.footers.auth')
    </div>
@endsection

@push('scripts-vars')
    <script>
        var salesCount ={!! json_encode($monthlySalesCount) !!};
        var salesData ={!! json_encode($totalSalesData) !!};
        var countChartData = {
            labels: Object.keys(salesCount),
            datasets: [{
                label: "{{ __('admin.performance') }}",
                data: Object.values(salesCount)
            }]
        };
        var salesChartData = {
            labels: Object.keys(salesData),
            datasets: [{
                label: "{{ __('admin.performance') }}",
                data: Object.values(salesData)
            }]
        };         
    </script>
@endpush


@push('js')
    <script src="{{ asset('admin-assets') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('admin-assets') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('admin-assets') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('admin-assets') }}/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var SITEURL = '{{url('partners')}}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var table = $('#partnership-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: "numbers",
                ajax: "{{ route('admin.partners') }}",
                language: {
                    url: "{{ app()->getLocale() == 'fr' ? asset('admin-assets/lang/french.json') : '' }}"
                },
                columns: [
                    {data: 'business_name', name: 'business_name'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'home_phone', name: 'home_phone'},
                    {data: 'mobile_phone', name: 'mobile_phone'},
                    {data: 'city', name: 'city'},
                    {data: 'province', name: 'province'},
                    {data: 'postal_code', name: 'postal_code'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });

            var table = $('#history-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: "numbers",
                ajax: "{{ route('admin.history') }}",
                language: {
                    url: "{{ app()->getLocale() == 'fr' ? asset('admin-assets/lang/french.json') : '' }}"
                },
                columns: [
                    {data: 'business_name', name: 'business_name'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'home_phone', name: 'home_phone'},
                    {data: 'mobile_phone', name: 'mobile_phone'},
                    {data: 'city', name: 'city'},
                    {data: 'province', name: 'province'},
                    {data: 'postal_code', name: 'postal_code'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });

            var table = $('#partner-sales-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: "numbers",
                ajax: "{{ route('admin.partnersales') }}",
                language: {
                    url: "{{ app()->getLocale() == 'fr' ? asset('admin-assets/lang/french.json') : '' }}"
                },
                columns: [
                    {data: 'business_name', name: 'business_name'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'promocode', name: 'promocode', orderable: false, searchable: true},
                    {data: 'promocode_value', name: 'promocode_value', orderable: false, searchable: true},
                    {data: 'promocode_usage', name: 'promocode_usage', orderable: false, searchable: true},
                    {data: 'total_referrals', name: 'total_referrals', orderable: false, searchable: true},
                    {data: 'total_sales', name: 'total_sales', orderable: false, searchable: true}
                ]
            });

            $('body').on('click', '.approve', function () {
                $('#partner_id').val($(this).data("id"));
                $('#approve-modal').modal('show');
            }); 

            $('body').on('click', '#submit-form', function () {
                $(this).prop("disabled", true);
                // add spinner to button
                $(this).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`+ "{{ __('admin.submitting') }}"
                );

                $.ajax({
                    type: "POST",
                    url: SITEURL + "/action/approve",
                    data: $('#voucher-form').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        var oTable = $('.data-table').dataTable(); 
                        oTable.fnDraw(false);
                        $(this).html(`Submit`);
                        $('#approve-modal').modal('hide')
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }); 
                
            $('body').on('click', '.reject', function () {
                var partnerId = $(this).data("id");
                if(confirm("{{ __('admin.reject_confirmation') }}")){
                    $.ajax({
                        type: "POST",
                        url: SITEURL + "/action/reject/" + partnerId,
                        success: function (data) {
                        var oTable = $('.data-table').dataTable(); 
                        oTable.fnDraw(false);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            }); 
                    
        });

    </script>
@endpush