@extends('layouts.admin')

@section('content')

    <h1 class="page-header">{{__('Dashboard')}}</h1>

    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h4>Tổng số user</h4>
                        <h3>{{$user_numbers}}</h3>
                    </div>
                    <div class="col-md-4">
                        <h4>Tổng số danh mục</h4>
                        <h3>{{$category_numbers}}</h3>
                    </div>
                    <div class="col-md-4">
                        <h4>Tổng số sản phẩm</h4>
                        <h3>{{$product_numbers}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h3 class="page-header">Doanh thu</h3>
            {{-- <div class="row" id="form">
                <div class="col-md-3">
                    <select class="form-control" name="month">
                        @for($i=1; $i <= 12; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="year">
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </div>
            </div> --}}
            <div class="container">
                <div id="chart"></div>
            </div>
            
        </div>
    </div>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        var d = new Date();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'GET',
            url : `/admin/revenue?month=${month}&year=${year}`,
            success : function(response){
                if(response){
                    
                    google.charts.load('current', {'packages':['line']});
                    
                    var data = [
                        ['Ngày', 'Doanh thu'],
                        ...response.data
                    ];

                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var chart_data = new google.visualization.arrayToDataTable(data);
                        var options = {
                            chart: {
                                title: `Doanh thu trong tháng ${month}/${year}`
                            },
                            width: 900,
                            height: 500
                        };

                        var chart = new google.charts.Line(document.getElementById('chart'));

                        chart.draw(chart_data, google.charts.Line.convertOptions(options));
                    }
                }
            }.bind(this),
            error: function(err) {
                console.log(err);
            }
        })
    
        
        // google.charts.setOnLoadCallback(drawChart);

        // function drawChart(data) {
        //     // var data = google.visualization.arrayToDataTable([
        //     // ['Year', 'Sales', 'Expenses'],
        //     // ['2004',  1000,      400],
        //     // ['2005',  1170,      460],
        //     // ['2006',  660,       1120],
        //     // ['2007',  1030,      540]
        //     // ]);

        //     var options = {
        //     title: 'Company Performance',
        //     // curveType: 'function',
        //     legend: { position: 'bottom' }
        //     };

        //     var chart = new google.visualization.LineChart(document.getElementById('chart'));

            
        // }
    </script>
@endsection