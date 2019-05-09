@extends('layouts.master', ['title' => 'Admin'])
@push('admin.css')
<link rel="stylesheet" href="{{asset('asset/global_assets/css/extras/daterangepicker.css')}}">
@endpush
@section('page_header')
<div class="page-header page-header-light noprint">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <span class="breadcrumb-item active">Tests Managment</span>
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
@stop
@section('content')
<!-- Basic initialization -->
<!-- Simple statistics -->
<div class="card noprint">
    <div class="card-header header-elements-inline">
        <h6 class="mb-0 font-weight-semibold">
        Total Statics
        </h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="card card-body bg-blue-400 has-bg-image">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{count(App\Invoice::where('date', date('Y-m-d'))->get())}}</h3>
                            <span class="text-uppercase font-size-xs">Today's Invoice
                                    <i class="icon-spinner9 spinner mr-2"></i></span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-clipboard2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card card-body bg-danger-400 has-bg-image">
                    <div class="media">
                        <div class="media-body"><?php $invoices = App\Invoice::where('date', date('Y-m-d'))->get()?>
                            <?php $total_test = 0;foreach ($invoices as $key => $value) {$total_test += count($value->invoice_items);}?>
                            <h3 class="mb-0">{{$total_test}}</h3>
                            <span class="text-uppercase font-size-xs">Today's Test <i class="icon-spinner9 spinner mr-2"></i></span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-lab icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card card-body bg-success-400 has-bg-image">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-pointer icon-3x opacity-75"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="mb-0">{{App\Expense::where('date', date('Y-m-d'))->sum('expense')}}</h3>
                            <span class="text-uppercase font-size-xs"><i class="icon-spinner9 spinner mr-2"></i> Today's Expense </i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card card-body bg-indigo-400 has-bg-image">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-coin-dollar icon-3x opacity-75"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="mb-0">{{App\Payment::where('date', date('Y-m-d'))->sum('payment')}}</h3>
                            <span class="text-uppercase font-size-xs"> <i class="icon-spinner9 spinner mr-2"></i> Today's Payment </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Daterange picker -->
<div class="card noprint">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Report</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="line_zoom"></div>
                </div>
            </div>
            <div class="col-md-3">
                {{-- <div class="form-group">
                    <label class="d-block">Select Date For See Report</label>
                    <button type="button" class="btn btn-light daterange-predefined">
                    <i class="icon-calendar22 mr-2"></i>
                    <span id="date"></span> <img id="ajaxloader" src="{{ asset('asset/ajaxloader.gif') }}" style="display:none; ">
                    </button>
                </div> --}}
                <div class="card card-body border-top-primary">
                    <div class="text-center">
                        <h6 class="mb-0 font-weight-semibold">Progress report</h6>
                    </div>
                        <span>Today's Invoice ({{(count(App\Invoice::where('date', date('Y-m-d'))->get()) / 1000 ) *100}}%)</span>
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" style="width: {{(count(App\Invoice::where('date', date('Y-m-d'))->get()) / 1000 ) *100}}%">
                            <span class="sr-only">{{(count(App\Invoice::where('date', date('Y-m-d'))->get()) / 1000 ) *100}}% Complete</span>
                        </div>
                    </div>
                    <span>This Month's Invoice ({{(count(App\Invoice::where('date', '>=', date('Y-m').'-01')->where('date', '<=', date('Y-m-d'))->get()) / 10000 ) *100}}%)</span>
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: {{(count(App\Invoice::where('date', '>=', Date('Y-m').'-01')->where('date', '<=', date('Y-m-d'))->get()) / 10000 ) *100}}%">
                            <span class="sr-only">{{(count(App\Invoice::where('date', '>=', date('Y-m').'-01')->where('date', '<=', date('Y-m-d'))->get()) / 10000 ) *100}}% Complete</span>
                        </div>
                    </div>
                    <span>This Year's Invoice ({{(count(App\Invoice::where('date', '>=', Date('Y').'-01-01')->where('date', '<=', date('Y-m-d'))->get()) / 100000 ) *100}}%)</span>
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: {{(count(App\Invoice::where('date', '>=', Date('Y').'-01-01')->where('date', '<=', date('Y-m-d'))->get()) / 100000 ) *100}}%">
                            <span class="sr-only">{{(count(App\Invoice::where('date', '>=', Date('Y').'-01-01')->where('date', '<=', date('Y-m-d'))->get()) / 100000 ) *100}}% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /simple statistics -->
<div class="card noprint">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Report</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="d-block">Select Date For See Report</label>
                    <button type="button" class="btn btn-light daterange-predefined" style="width: 100%">
                    <i class="icon-calendar22 mr-2"></i>
                    <span id="date"></span> <img id="ajaxloader" src="{{ asset('asset/ajaxloader.gif') }}" style="display:none; ">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="report">
</div>
@endsection
@push('admin.scripts')
<script src="{{ asset('asset/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
<script src="{{ asset('asset/assets/js/app.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/pages/admin-dashboard.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/visualization/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/loaders/progressbar.min.js') }}"></script>
<script>
var EchartsLines = function() {
var _lineChartExamples = function() {
if (typeof echarts == 'undefined') {
console.warn('Warning - echarts.min.js is not loaded.');
return;
}
// Define elements
var line_zoom_element = document.getElementById('line_zoom');
// Zoom option
if (line_zoom_element) {
// Initialize chart
var line_zoom = echarts.init(line_zoom_element);
//
// Chart config
//
// Options
line_zoom.setOption({
// Define colors
color: ["#424956", "#d74e67", '#0092ff'],
// Global text styles
textStyle: {
fontFamily: 'Roboto, Arial, Verdana, sans-serif',
fontSize: 13
},
// Chart animation duration
animationDuration: 750,
// Setup grid
grid: {
left: 0,
right: 40,
top: 35,
bottom: 60,
containLabel: true
},
// Add legend
legend: {
data: ['Software', 'Hardware', 'Accessories'],
itemHeight: 8,
itemGap: 20
},
// Add tooltip
tooltip: {
trigger: 'axis',
backgroundColor: 'rgba(0,0,0,0.75)',
padding: [10, 15],
textStyle: {
fontSize: 13,
fontFamily: 'Roboto, sans-serif'
}
},
// Horizontal axis
xAxis: [{
type: 'category',
boundaryGap: false,
axisLabel: {
color: '#333'
},
axisLine: {
lineStyle: {
color: '#999'
}
},
data: [{!!$return_date!!}]
}],
// Vertical axis
yAxis: [{
type: 'value',
axisLabel: {
formatter: '{value} ',
color: '#333'
},
axisLine: {
lineStyle: {
color: '#999'
}
},
splitLine: {
lineStyle: {
color: ['#eee']
}
},
splitArea: {
show: true,
areaStyle: {
color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
}
}
}],
// Zoom control
dataZoom: [
{
type: 'inside',
start: 30,
end: 70
},
{
show: true,
type: 'slider',
start: 30,
end: 70,
height: 40,
bottom: 0,
borderColor: '#ccc',
fillerColor: 'rgba(0,0,0,0.05)',
handleStyle: {
color: '#585f63'
}
}
],
// Add series
series: [
{
name: 'Income',
type: 'line',
smooth: true,
symbolSize: 6,
itemStyle: {
normal: {
borderWidth: 2
}
},
data: [{{$return_payment}}]
},
{
name: 'Expense',
type: 'line',
smooth: true,
symbolSize: 6,
itemStyle: {
normal: {
borderWidth: 2
}
},
data: [{{$return_expanse}}]
},
{
name: 'Commission',
type: 'line',
smooth: true,
symbolSize: 6,
itemStyle: {
normal: {
borderWidth: 2
}
},
data: [{{$return_commission}}]
}
]
});
}
//
// Resize charts
//
// Resize function
var triggerChartResize = function() {
line_zoom_element && line_zoom.resize();
};
// On sidebar width change
$(document).on('click', '.sidebar-control', function() {
setTimeout(function () {
triggerChartResize();
}, 0);
});
// On window resize
var resizeCharts;
window.onresize = function () {
clearTimeout(resizeCharts);
resizeCharts = setTimeout(function () {
triggerChartResize();
}, 200);
};
};
//
// Return objects assigned to module
//
return {
init: function() {
_lineChartExamples();
}
}
}();
// Initialize module
// ------------------------------
document.addEventListener('DOMContentLoaded', function() {
EchartsLines.init();
});
</script>
@endpush