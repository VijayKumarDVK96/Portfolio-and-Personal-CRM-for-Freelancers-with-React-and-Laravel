@extends('includes.admin-layout')

@section('styles')
  <link href="{{url('plugins/chart/morris/css/morris.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 xl-100 chart_data_left box-col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row m-0 chart-main">
                        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                            <div class="media align-items-center">
                                <div class="hospital-small-chart">
                                    <div class="small-bar">
                                        <div class="small-chart flot-chart-container">
                                            <div class="chartist-tooltip"></div><svg
                                                xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%"
                                                height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                                <g class="ct-grids"></g>
                                                <g>
                                                    <g class="ct-series ct-series-a">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="69"
                                                            y2="58.2" class="ct-bar" ct:value="400"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="69"
                                                            y2="44.7" class="ct-bar" ct:value="900"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="69"
                                                            y2="47.4" class="ct-bar" ct:value="800"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="69" y2="42" class="ct-bar"
                                                            ct:value="1000" style="stroke-width: 3px"></line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="69"
                                                            y2="50.1" class="ct-bar" ct:value="700"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="69"
                                                            y2="36.6" class="ct-bar" ct:value="1200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="69"
                                                            y2="60.9" class="ct-bar" ct:value="300"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                    <g class="ct-series ct-series-b">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="58.2"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="1000"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="44.7"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="500"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="47.4"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="600"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="42" y2="31.200000000000003"
                                                            class="ct-bar" ct:value="400" style="stroke-width: 3px">
                                                        </line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="50.1"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="700"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="36.6"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="60.9"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="1100"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                </g>
                                                <g class="ct-labels"></g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="right-chart-content">
                                        <h4>{{$counts->clients}}</h4><span> Total Clients</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                            <div class="media align-items-center">
                                <div class="hospital-small-chart">
                                    <div class="small-bar">
                                        <div class="small-chart1 flot-chart-container">
                                            <div class="chartist-tooltip"></div><svg
                                                xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%"
                                                height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                                <g class="ct-grids"></g>
                                                <g>
                                                    <g class="ct-series ct-series-a">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="69"
                                                            y2="58.2" class="ct-bar" ct:value="400"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="69"
                                                            y2="52.8" class="ct-bar" ct:value="600"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="69"
                                                            y2="44.7" class="ct-bar" ct:value="900"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="69" y2="47.4" class="ct-bar"
                                                            ct:value="800" style="stroke-width: 3px"></line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="69"
                                                            y2="42" class="ct-bar" ct:value="1000"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="69"
                                                            y2="36.6" class="ct-bar" ct:value="1200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="69"
                                                            y2="55.5" class="ct-bar" ct:value="500"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                    <g class="ct-series ct-series-b">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="58.2"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="1000"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="52.8"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="800"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="44.7"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="500"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="47.4" y2="31.199999999999996"
                                                            class="ct-bar" ct:value="600" style="stroke-width: 3px">
                                                        </line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="42"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="400"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="36.6"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="55.5"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="900"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                </g>
                                                <g class="ct-labels"></g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="right-chart-content">
                                        <h4>{{$counts->projects}}</h4><span> Total Projects</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                            <div class="media align-items-center">
                                <div class="hospital-small-chart">
                                    <div class="small-bar">
                                        <div class="small-chart2 flot-chart-container">
                                            <div class="chartist-tooltip"></div><svg
                                                xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%"
                                                height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                                <g class="ct-grids"></g>
                                                <g>
                                                    <g class="ct-series ct-series-a">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="69"
                                                            y2="39.3" class="ct-bar" ct:value="1100"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="69"
                                                            y2="44.7" class="ct-bar" ct:value="900"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="69"
                                                            y2="52.8" class="ct-bar" ct:value="600"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="69" y2="42" class="ct-bar"
                                                            ct:value="1000" style="stroke-width: 3px"></line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="69"
                                                            y2="50.1" class="ct-bar" ct:value="700"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="69"
                                                            y2="36.6" class="ct-bar" ct:value="1200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="69"
                                                            y2="60.9" class="ct-bar" ct:value="300"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                    <g class="ct-series ct-series-b">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="39.3"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="300"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="44.7"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="500"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="52.8"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="800"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="42" y2="31.200000000000003"
                                                            class="ct-bar" ct:value="400" style="stroke-width: 3px">
                                                        </line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="50.1"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="700"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="36.6"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="60.9"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="1100"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                </g>
                                                <g class="ct-labels"></g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="right-chart-content">
                                        <h4>{{$counts->pending_projects}}</h4><span> Ongoing Projects</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                            <div class="media border-none align-items-center">
                                <div class="hospital-small-chart">
                                    <div class="small-bar">
                                        <div class="small-chart3 flot-chart-container">
                                            <div class="chartist-tooltip"></div><svg
                                                xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%"
                                                height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                                <g class="ct-grids"></g>
                                                <g>
                                                    <g class="ct-series ct-series-a">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="69"
                                                            y2="58.2" class="ct-bar" ct:value="400"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="69"
                                                            y2="52.8" class="ct-bar" ct:value="600"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="69"
                                                            y2="47.4" class="ct-bar" ct:value="800"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="69" y2="42" class="ct-bar"
                                                            ct:value="1000" style="stroke-width: 3px"></line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="69"
                                                            y2="50.1" class="ct-bar" ct:value="700"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="69"
                                                            y2="39.3" class="ct-bar" ct:value="1100"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="69"
                                                            y2="60.9" class="ct-bar" ct:value="300"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                    <g class="ct-series ct-series-b">
                                                        <line x1="13.571428571428571" x2="13.571428571428571" y1="58.2"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="1000"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="20.714285714285715" x2="20.714285714285715" y1="52.8"
                                                            y2="39.3" class="ct-bar" ct:value="500"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="27.857142857142858" x2="27.857142857142858" y1="47.4"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="600"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="35" x2="35" y1="42" y2="33.9" class="ct-bar"
                                                            ct:value="300" style="stroke-width: 3px"></line>
                                                        <line x1="42.14285714285714" x2="42.14285714285714" y1="50.1"
                                                            y2="31.200000000000003" class="ct-bar" ct:value="700"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="49.285714285714285" x2="49.285714285714285" y1="39.3"
                                                            y2="33.9" class="ct-bar" ct:value="200"
                                                            style="stroke-width: 3px"></line>
                                                        <line x1="56.42857142857143" x2="56.42857142857143" y1="60.9"
                                                            y2="31.199999999999996" class="ct-bar" ct:value="1100"
                                                            style="stroke-width: 3px"></line>
                                                    </g>
                                                </g>
                                                <g class="ct-labels"></g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="right-chart-content">
                                        <h4>{{$counts->completed_projects}}</h4><span> Completed Projects</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card shadow-none border border-light">
                                <div class="card-header  border-light">
                                    <h5>INCOME SUMMARY FOR {{date('Y')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div id="monthly_summary" style="height:300px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card-header border-light">
                                <h5>CATEGORIES SUMMARY</h5>
                            </div>
                            <div class="card-body p-0 chart-block">
                                <div class="chart-overflow" id="pie-chart3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/chart/Chart.js/Chart.min.js')}}"></script>
    <script src="{{url('plugins/chart/raphael/raphael-min.js')}}"></script>
    <script src="{{url('plugins/chart/morris/js/morris.js')}}"></script>
    <script src="{{url('plugins/chart/google/google-chart-loader.js')}}"></script>

    <script>
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    Morris.Area({
        element: 'monthly_summary',
        data: [
            @foreach($monthly_summary as $value)
            {
                month: '{{$value["month"]}}',
                amount: {{$value["amount"]}},
            },
            @endforeach
        ],
        xkey: 'month',
        ykeys: ['amount'],
        labels: ['Amount Rs'],
        xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
            var month = months[x.getMonth()];
            return month;
        },
        dateFormat: function (x) {
            var month = months[new Date(x).getMonth()];
            return month;
        },
        pointSize: 3,
        fillOpacity: 0,
        pointStrokeColors: ['#008cff', '#15ca20'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 3,
        hideHover: 'auto',
        lineColors: ['#008cff', '#15ca20'],
        resize: true
    });
  </script>

  <script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawBasic);
    function drawBasic() {
        if ($("#pie-chart3").length > 0) {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Count'],
                @foreach($categories as $value)
                ['{{$value->category}}', {{$value->count}}],
                @endforeach
            ]);
            var options = {
                // title: 'My Daily Activities',
                pieHole: 0.4,
                width:'100%',
                height: 300,
                colors: ["#f8d62b", "#a927f9", "#51bb25", CubaAdminConfig.secondary , CubaAdminConfig.primary]
            };
            var chart = new google.visualization.PieChart(document.getElementById('pie-chart3'));
            chart.draw(data, options);
        }
    }

  </script>
@endsection