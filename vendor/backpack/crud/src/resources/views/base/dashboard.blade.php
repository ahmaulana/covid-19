@extends(backpack_view('blank'))

@section('before_styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .emotion-icon {
        max-width: 30% !important;
    }    
</style>
@endsection
@section('content')
<div class="card-group mb-4">
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ asset('img/happy.png') }}" class="img-fluid emotion-icon" alt="">
                <div class="text-value happy">0</div><a href="{{ url('tweet') . '?emotion=senang' }}"><small class="text-muted text-uppercase font-weight-bold">Senang</small></a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ asset('img/sad.png') }}" class="img-fluid emotion-icon" alt="">
                <div class="text-value sadness">0</div><a href="{{ url('tweet') . '?emotion=sedih' }}"><small class="text-muted text-uppercase font-weight-bold">Sedih</small></a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ asset('img/angry.png') }}" class="img-fluid emotion-icon" alt="">
                <div class="text-value anger">0</div><a href="{{ url('tweet') . '?emotion=marah' }}"><small class="text-muted text-uppercase font-weight-bold">Marah</small></a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ asset('img/fear.png') }}" class="img-fluid emotion-icon" alt="">
                <div class="text-value fear">0</div><a href="{{ url('tweet') . '?emotion=takut' }}"><small class="text-muted text-uppercase font-weight-bold">Takut</small></a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ asset('img/love.png') }}" class="img-fluid emotion-icon" alt="">
                <div class="text-value love">0</div><a href="{{ url('tweet') . '?emotion=cinta' }}"><small class="text-muted text-uppercase font-weight-bold">Cinta</small></a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">Perkembangan Terkini Reaksi Publik</h4>
                <div class="small text-muted">Periode: <b>1 jam terakhir</b></div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
        <div class="chart-wrapper" style="height:300px;margin-top:20px;">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                </div>
            </div>
            <canvas class="chart chartjs-render-monitor" id="main-chart" height="300" width="422" style="display: block; width: 422px; height: 300px;"></canvas>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-2">Tren Reaksi Publik Waktu ke Waktu</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="small text-muted">Periode: <b><span class="periode">-</span></b></div>
                <div class="small text-muted">Terakhir diperbarui: <b><span class="last-updated">-</span></b></div>
            </div>
            <div class="col-sm-6">
                <div class="card-header-actions">
                    <small class="text-muted">
                        <div class="form-group col-sm-12" element="div">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="date-range">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="la la-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </small>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="chart-wrapper" style="height:300px;margin-top:10px;">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                </div>
            </div>
            <canvas id="filter-chart" class="chartjs-render-monitor" height="300" width="422" style="display: block; width: 422px; height: 300px;"></canvas>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header" style="z-index: 10;">
        <h4 class="card-title mb-2">Topik Populer yang Dibahas</h4>
        <div class="small text-muted">Periode: <b><span class="periode-word">-</span></b></div>
        <div class="small text-muted">Terakhir diperbarui: <b><span class="last-updated-word">-</span></b></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header-actions">
                    <small class="text-muted">
                        <form id="form-word-cloud" class="form-inline">
                            <div class="input-group">
                                <select id="emotion" name="emotion" class="form-control mr-2">
                                    <option value="senang">Senang</option>
                                    <option value="sedih">Sedih</option>
                                    <option value="marah">Marah</option>
                                    <option value="cinta">Cinta</option>
                                    <option value="takut">Takut</option>
                                </select>
                                <div class="input-group date mr-2">
                                    <input type="text" class="form-control" id="date-range-word">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="la la-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" id="update-word-cloud" type="submit">update</button>
                                </div>
                            </div>
                        </form>
                    </small>
                </div>
            </div>
        </div>
        <div class="loader">
            <div class="half-circle-spinner d-flex justify-content-center">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
            <div class="overlay"></div>
        </div>
        <div class="chart-wrapper">
            <div id="word-cloud" class="w-100" style="height:300px"></div>
        </div>
    </div>
</div>
@endsection
@section('after_scripts')
<script src="/packages/wordcloud/wordcloud2.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        //Loader
        $(".loader").toggleClass('d-none');

        var total = <?= json_encode($total) ?>;
        countEmotion(total);

        //Initialize Date Range
        $("#date-range").daterangepicker({
            maxDate: new Date(),
            alwaysShowCalendars: true,
            locale: {
                format: 'DD/MM/YYYY'
            },

            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(7, 'days'),
            endDate: moment()
        });
        //Initialize Date Range
        $("#date-range-word").daterangepicker({
            maxDate: new Date(),
            alwaysShowCalendars: true,
            dateLimit: { days: 7 },
            locale: {
                format: 'DD/MM/YYYY'
            },

            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],                
            },
            startDate: moment(),
            endDate: moment()
        });

        //Filter Chart
        getChartData(moment().subtract(7, 'd').format('Y-MM-DD'), moment().format('Y-MM-DD'));

        //Get Word Cloud
        getWordCloud();

        //Update Word Cloud
        $(".btn-update").on("click", function() {
            getWordCloud();
        });
    });
    var label = <?= json_encode($emotions_chart['label']) ?>;
    var anger = <?= json_encode($emotions_chart['emotion']['marah']) ?>;
    var fear = <?= json_encode($emotions_chart['emotion']['takut']) ?>;
    var happy = <?= json_encode($emotions_chart['emotion']['senang']) ?>;
    var love = <?= json_encode($emotions_chart['emotion']['cinta']) ?>;
    var sadness = <?= json_encode($emotions_chart['emotion']['sedih']) ?>;
    var mainChart = new Chart($('#main-chart'), {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: 'Takut',
                backgroundColor: 'transparent',
                borderColor: 'grey',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: fear
            }, {
                label: 'Cinta',
                backgroundColor: 'transparent',
                borderColor: 'pink',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: love
            }, {
                label: 'Marah',
                backgroundColor: 'transparent',
                borderColor: 'red',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: anger
            }, {
                label: 'Sedih',
                backgroundColor: 'transparent',
                borderColor: 'blue',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: sadness
            }, {

                label: 'Senang',
                backgroundColor: 'transparent',
                borderColor: 'yellow',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: happy
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        displayFormats: {
                            minute: 'h:mm a'
                        }
                    },
                    gridLines: {
                        drawOnChartArea: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        maxTicksLimit: 5,
                    }
                }]
            },
            elements: {
                point: {
                    radius: 2,
                    hitRadius: 10,
                    hoverRadius: 4,
                    hoverBorderWidth: 3
                }
            },
            tooltips: {
                mode: 'index'
            }
        }
    });

    var lineChart = new Chart($('#filter-chart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Takut',
                backgroundColor: 'transparent',
                borderColor: 'grey',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: []
            }, {
                label: 'Cinta',
                backgroundColor: 'transparent',
                borderColor: 'pink',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: []
            }, {
                label: 'Marah',
                backgroundColor: 'transparent',
                borderColor: 'red',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: []
            }, {
                label: 'Sedih',
                backgroundColor: 'transparent',
                borderColor: 'blue',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: []
            }, {
                label: 'Senang',
                backgroundColor: 'transparent',
                borderColor: 'yellow',
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: []
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    gridLines: {
                        drawOnChartArea: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        maxTicksLimit: 5,
                    }
                }]
            },
            elements: {
                point: {
                    radius: 2,
                    hitRadius: 10,
                    hoverRadius: 4,
                    hoverBorderWidth: 3
                }
            },
            tooltips: {
                mode: 'index'
            }
        }
    });

    function addData(chart, label, data) {
        chart.data.labels.push(label);
        chart.data.labels.shift();
        chart.data.datasets.forEach((dataset, index) => {
            dataset.data.shift();
            dataset.data.push(data[index]);
        });
        chart.update();
    }

    function countEmotion(data) {
        $(".fear").html(data[0]['total']);
        $(".love").html(data[1]['total']);
        $(".anger").html(data[2]['total']);
        $(".sadness").html(data[3]['total']);
        $(".happy").html(data[4]['total']);
    }

    function getChartData(start, end) {
        //Get data by AJAX        
        var url = "<?= route("chart.read") ?>";
        $.ajax({
            method: "POST",
            url: url,
            data: {
                startDate: start,
                endDate: end
            },
            success: function(data) {
                //convert date
                let startDate = moment(start);
                let endDate = moment(end);                
                $(".periode").text(startDate.format("DD/MM/YYYY") + " hingga " + endDate.format("DD/MM/YYYY"));
                $(".last-updated").text(moment().format("DD/MM/YYYY, h:mm:ss a"));
                updateChartData(lineChart, data);
            }
        });
    }

    function updateChartData(chart, data) {
        chart.data.labels = data.label;
        chart.data.datasets.forEach((dataset, index) => {
            dataset.data = data.emotion[index];
        });
        chart.update();
    }

    function getWordCloud() {
        var emotion = $("#emotion").val();
        var start = moment($("#date-range-word").data('daterangepicker').startDate._d).format('Y-MM-DD');
        var end = moment($("#date-range-word").data('daterangepicker').endDate._d).format('Y-MM-DD');
        var url = "<?= route('word.cloud') ?>";
        $.ajax({
            url: url,
            method: "POST",
            data: {
                emotion: emotion,
                startDate: start,
                endDate: end
            },
            dataType: "json",
            beforeSend: function() {
                $(".loader").toggleClass('d-none');
                $("#update-word-cloud").attr("disabled", true);
            },
            success: function(data) {
                $(".loader").toggleClass('d-none');
                $("#update-word-cloud").attr("disabled", false);
                WordCloud(document.getElementById('word-cloud'), {
                    list: data
                });
                let startDate = moment(start);
                let endDate = moment(end);                
                $(".periode-word").text(startDate.format("DD/MM/YYYY") + " hingga " + endDate.format("DD/MM/YYYY"));
                $(".last-updated-word").text(moment().format("DD/MM/YYYY, h:mm:ss a"));
            }
        });
    }
</script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('d6dc82355927033668cd', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('chart-event');
    channel.bind('chart', function(data) {
        addData(mainChart, data.message.label, data.message.emotion);
        countEmotion(data.message.total);
    });
    $(document).ready(function() {
        $('#date-range').on('apply.daterangepicker', function(ev, picker) {
            var start = moment(picker.startDate).format('Y-MM-DD');
            var end = moment(picker.endDate).format('Y-MM-DD');
            getChartData(start, end);
        });
        $("#form-word-cloud").on("submit", function(e) {
            e.preventDefault();
            getWordCloud();
        });
    });
</script>
@endsection