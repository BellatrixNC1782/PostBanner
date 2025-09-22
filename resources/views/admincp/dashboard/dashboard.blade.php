@extends('Layouts.appadmin')
@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="page-leftheader">
                <!--<h4 class="page-title mb-0">Hi! Welcome Back</h4>-->
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="fe fe-file-text me-2 fs-14 d-inline-flex"></i>Dashboard</a></li>
                </ol>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Row-1 -->
        <div class="row dashboard-box-row">
            <div class="col-xl-3 col-lg-6 col-md-12">
                <div class="card redirect-link" data-link="{{ route('userlist') }}">
                    <div class="card-body">
                        <svg class="card-custom-icon stroke" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 19H1V18C1 16.1362 2.27477 14.5701 4 14.126M6 10.8293C4.83481 10.4175 4 9.30621 4 7.99999C4 6.69378 4.83481 5.58254 6 5.1707M21 19H23V18C23 16.1362 21.7252 14.5701 20 14.126M18 5.1707C19.1652 5.58254 20 6.69378 20 7.99999C20 9.30621 19.1652 10.4175 18 10.8293M10 14H14C16.2091 14 18 15.7909 18 18V19H6V18C6 15.7909 7.79086 14 10 14ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class=" mb-1">Users</p>
                        <h2 class="mb-1 fw-bold">{{ $total_users }}</h2>

                    </div>
                </div>
            </div>
            
        </div>
        <!-- End Row-1 -->

        <!-- Row-2 -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Users Chart</div>
                    </div>
                    @if(count($year))
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 offset-sm-6">
                                <div class="float-end">
                                    <select class="form-control" onChange="getUserChart();" name="user_chart" id="user_chart">
                                        @foreach($year as $years)
                                        <option value="{{$years}}" <?php if (date('Y') == $years) {
                                    echo "selected";
                                } ?>>{{$years}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <canvas id="userChart" class="chartjs-chart"></canvas>
                    </div>
                    @else
                    <div class="card-body">
                        <p>No data found</p>
                    </div>
                    @endif
                </div>
            </div>
            
        </div>
        <!-- End Row-2 -->
    </div>
</div>
<!-- End::app-content -->
@endsection

@section('javascript')
<script>
    $(document).on("click", ".redirect-link", function() {
        var redirectLink = $(this).attr('data-link');
        if (redirectLink) {
            window.location.href = redirectLink;
        }
    });

    function getUserChart() {
        var current_year = $('#user_chart').val();
        if (current_year == "") {
            var d = new Date();
            current_year = d.getFullYear();
        }
        var admin_path = "{{ env('ADMIN_URL') }}";
        $.ajax({
            url: admin_path + 'getuserchart/' + current_year,
            method: 'get',
            success: function(data) {
                userDrawChart(data.response)
            },
            error: function(data) {
                console.log('errror')
            }
        });
    }

    function userDrawChart(response) {

        const month_wise_user_label = response.month_wise_user_label;
        const month_wise_user_count = response.month_wise_user_count;
        const month_wise_con_count = response.month_wise_con_count;
        const month_wise_sub_con_count = response.month_wise_sub_con_count;

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: {
                    gridLines: {
                        display: false,
                    },
                },
                yAxes: {
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        beginAtZero: true,
                        callback: (label) => `${label}`,
                    },
                }
            },
            tooltips: {
                callbacks: {
                    label: context => context.value,

                }
            },
        }

        var clubDataset = {
            label: 'Users',
            data: month_wise_user_count,
            fill: false,
            borderColor: '#8355FE',
            backgroundColor: '#8355FE',
        };


        var areaChartData = {
            labels: month_wise_user_label,
            datasets: [clubDataset]
        }

        var lineChartCanvas = $('#userChart').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        var boxoption = {
            display: true,
            position: 'top',
            labels: {
                boxWidth: 50,
                fontColor: 'black',
                fontSize: 15
            }
        };
        lineChartOptions.legend = boxoption
        if (window.lineChart instanceof Chart) {
            window.lineChart.destroy();
        }
        window.lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });

    }

    


    $(function() {
        getUserChart();
    });

</script>
@endsection
