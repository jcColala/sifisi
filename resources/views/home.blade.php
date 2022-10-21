@extends('layouts.app')
@section('content')
<div class="page-header">
    <!-- START NAVBAR Header -->
    @include('layouts.navbar',['title'=>'Bienvenido','modulo'=>"SIFISI",'paht'=>'Inicio'])
    <!-- END NAVBAR Header -->
</div>
<!-- ROW-1 OPEN -->
<div class="col-12">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Revenue Vs Expenses</h3>
            </div>
            <div class="card-body ">
                <div id="index" class="overflow-hidden h-300 chart-dropshadow"></div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-1 CLOSED -->

<!-- ROW-2 OPEN -->
<div class="row">
    <div class=" col-md-12 col-lg-12 col-xl-7">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card overflow-hidden">
                    <div class="card-body pb-0">
                        <div class="float-left">
                            <h6 class="mb-1">Total Quantity</h6>
                            <h2 class="number-font mb-2">9,54,777</h2>
                            <p class="mb-2 text-muted">
                                <span class="mb-0 text-success fs-13 ">
                                    <i class="fe fe-arrow-up"></i> 23%
                                </span>
                                for Last month
                            </p>
                        </div>
                        <div class="float-right">
                            <span class="mini-stat-icon bg-info"><i class="si si-eye "></i></span>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                        <div class="chart-wrapper overflow-hidden">
                            <canvas id="areaChart1" class="areaChart overflow-hidden chart-dropshadow-info"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="float-left">
                            <h6 class="mb-1">Total Cost</h6>
                            <h2 class="number-font mb-2">$ 67,897</h2>
                            <p class="mb-2 text-muted">
                                <span class="mb-0 text-danger fs-13 ">
                                    <i class="fe fe-arrow-down"></i> 12%
                                </span>
                                for Last month
                            </p>
                        </div>
                        <div class="float-right">
                            <span class="mini-stat-icon bg-danger"><i class="si si-volume-2"></i></span>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                        <div class="chart-wrapper ">
                            <canvas id="areaChart2" class="areaChart chart-dropshadow-secondary"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="float-left">
                            <h6 class="mb-1">Total Revenue</h6>
                            <h2 class="number-font mb-2">178,698</h2>
                            <p class="mb-2 text-muted">
                                <span class="mb-0 text-success fs-13 ">
                                    <i class="fe fe-arrow-up"></i> 26%
                                </span>for Last month
                            </p>
                        </div>
                        <div class="float-right">
                            <span class="mini-stat-icon bg-warning"><i class="si si-chart"></i></span>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                        <div class="chart-wrapper ">
                            <canvas id="areaChart3" class="areaChart chart-dropshadow-success"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="float-left">
                            <h6 class="mb-1">Total Profit</h6>
                            <h2 class="number-font mb-2">34,789</h2>
                            <p class="mb-2 text-muted">
                                <span class="mb-0 text-danger fs-13">
                                    <i class="fe fe-arrow-down"></i> 15%
                                </span>
                                for Last month
                            </p>
                        </div>
                        <div class="float-right">
                            <span class="mini-stat-icon bg-success"><i class="si si-user"></i></span>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-0 border-top-0 overflow-hidden">
                        <div class="chart-wrapper ">
                            <canvas id="areaChart4" class="areaChart chart-dropshadow-warning"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-5">
        <div class="card  overflow-hidden">
            <div class="card-header">
                <h3 class="card-title">Sales By Category</h3>
            </div>
            <div class="card-body text-center">
                <div id="morrisBar8" class="h-340 donutShadow"></div>
                <div class="mt-2 text-center">
                    <span class="dot-label bg-info"></span><span class="mr-3">Technology</span>
                    <span class="dot-label bg-secondary"></span><span class="mr-3">Furniture</span>
                    <span class="dot-label bg-success"></span><span class="mr-3">Office Suppliers</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-2 CLOSED -->
@endsection
@section('script')
<script src="{{asset('js/index.js')}}"></script>
@endsection
