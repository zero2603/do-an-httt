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
            <div class="row" id="filter-form">
                <div class="col-md-3">Bộ lọc doanh thu: </div>
                <div class="col-md-3">
                    <select class="form-control" name="month" onchange="change(this);">
                        <option value="">Tháng</option>
                        @for($i=1; $i <= 12; $i++)
                            <option class="month" value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="year" onchange="change(this);">
                        <option value="">Năm</option>
                        <option class="year" value="2018">2018</option>
                        <option class="year" value="2019">2019</option>
                        <option class="year" value="2020">2020</option>
                    </select>
                </div>
            </div>
            <div>
                <div id="chart"></div>
            </div>
            
        </div>
    </div>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        var d = new Date();

        var url = new URL(window.location.href);
        var urlParams = new URLSearchParams(url.search.slice(1));

        var month = urlParams.get('month') || d.getMonth() + 1;
        var year = urlParams.get('year') || d.getFullYear();

        var monthOptions = document.getElementsByClassName("month");
        for(let element of monthOptions) {
            if(element.value.toString() === urlParams.get('month')) {
                element.setAttribute('selected', true);
            } else {
                element.removeAttribute('selected');
            }
        }

        var yearOptions = document.getElementsByClassName("year");
        for(let element of yearOptions) {
            if(element.value.toString() === urlParams.get('year')) {
                element.setAttribute('selected', true);
            } else {
                element.removeAttribute('selected');
            }
        }

        // call api statistic
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
                                title: `Tổng có ${response.orders} đơn hàng trong tháng. Doanh thu trong tháng ${month}/${year}`
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

        function change(item) {
            if(item.value) {
                urlParams.set(item.name, item.value);
            } else {
                urlParams.delete(item.name, item.value);
            }
            
            if(urlParams.get('month') && urlParams.get('year')) {
                window.location.href = window.location.origin + '/admin?' + urlParams.toString();
            }
            
        }
    </script>
@endsection