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
                                <h3 class="mb-0">{{ __('admin.classified_ads') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-4">
                        <!-- Projects table -->
                        <table id="history-table" class="table align-items-center table-flush data-table">
                            <thead>
                                <tr>
                                    {{-- <th>{{ __('auth.first_name') }}</th> --}}
                                    <th>{{ __('id') }}</th>
                                    <th>{{ __('title') }}</th>
                                    <th>{{ __('descriptions') }}</th>
                                    <th>{{ __('citq') }}</th>
                                    <th>{{ __('price') }}</th>
                                    <th>{{ __('category_name') }}</th>
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
            
            

            var table = $('#history-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: "numbers",
                ajax: {
            		"url": "{{ route('admin.history') }}",
            		// "cache": true
                },
                language: {
                    url: "{{ app()->getLocale() == 'fr' ? asset('admin-assets/lang/french.json') : '' }}"
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'descriptions', name: 'descriptions'},
                    {data: 'citq', name: 'citq'},
                    {data: 'price', name: 'price'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });

            

        });

    </script>
@endpush