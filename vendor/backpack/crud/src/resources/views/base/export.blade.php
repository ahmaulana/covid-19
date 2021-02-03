@extends(backpack_view('blank'))

@section('before_styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .error {
        color: red;
    }

    .emotion-icon {
        max-width: 30% !important;
    }
</style>
@endsection
@section('content')
<h2>
    <span class="text-capitalize">Cetak Laporan</span>
</h2>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <form id="form-export" class="form-horizontal">
                <div class="card-header">Cetak laporan berdasarkan rentang tanggal</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-range">Tanggal</label>
                        <div class="col-md-9">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="date-range">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="la la-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Cetak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <form id="form-export-word" class="form-horizontal">
                <div class="card-header">Cetak topik populer berdasarkan emosi</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="date-range-word">Tanggal</label>
                        <div class="col-md-9">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="date-range-word">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="la la-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="select1">Emosi</label>
                        <div class="col-md-9">
                            <select class="form-control" id="emotion" name="emotion">
                                <option value="">Pilih emosi...</option>
                                <option value="Senang">Senang</option>
                                <option value="Sedih">Sedih</option>
                                <option value="Marah">Marah</option>
                                <option value="Cinta">Cinta</option>
                                <option value="Takut">Takut</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Cetak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('after_scripts')
<!-- Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">File sedang diproses, mohon tunggu...</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="export-container">
                <h5 class="card-title mb-2">Sistem Pengawasan Reaksi Publik untuk COVID-19</h5>
                <div class="loader">
                    <div class="half-circle-spinner d-flex justify-content-center">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                    <div class="overlay"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="small text-muted">Tanggal: <b><span class="periode">-</span></b></div>
                        <div class="small text-muted">Terakhir diperbarui: <b><span class="last-updated">-</span></b></div>
                    </div>
                </div>
                <div class="card-group mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="http://164.68.99.64/img/happy.png" class="img-fluid emotion-icon" alt="">
                                <div class="text-value happy">-</div><small class="text-muted text-uppercase font-weight-bold">Senang</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="http://164.68.99.64/img/sad.png" class="img-fluid emotion-icon" alt="">
                                <div class="text-value sadness">-</div><small class="text-muted text-uppercase font-weight-bold">Sedih</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="http://164.68.99.64/img/angry.png" class="img-fluid emotion-icon" alt="">
                                <div class="text-value anger">-</div><small class="text-muted text-uppercase font-weight-bold">Marah</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="http://164.68.99.64/img/fear.png" class="img-fluid emotion-icon" alt="">
                                <div class="text-value fear">-</div><small class="text-muted text-uppercase font-weight-bold">Takut</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="http://164.68.99.64/img/love.png" class="img-fluid emotion-icon" alt="">
                                <div class="text-value love">-</div><small class="text-muted text-uppercase font-weight-bold">Cinta</small>
                            </div>
                        </div>
                    </div>
                </div>
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
            <div class="modal-footer">
                <div class="form-inline">
                    <div class="input-group">
                        <select id="export-file" name="export-file" class="form-control mr-2">
                            <option value="png">PNG</option>
                            <option value="pdf">PDF</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" onclick="print('export-file','export-container')" type="submit">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>

<!-- Modal -->
<div class="modal fade" id="exportWordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">File sedang diproses, mohon tunggu...</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="export-word-container">
                <h5 class="card-title mb-2">Sistem Pengawasan Reaksi Publik untuk COVID-19</h5>
                <div class="loader">
                    <div class="half-circle-spinner d-flex justify-content-center">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                    <div class="overlay"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="small text-muted">Emosi: <b><span class="emotion">-</span></b></div>
                        <div class="small text-muted">Tanggal: <b><span class="periode">-</span></b></div>
                        <div class="small text-muted">Terakhir diperbarui: <b><span class="last-updated">-</span></b></div>
                    </div>
                </div>
                <div id="export-word-cloud"></div>
            </div>
            <div class="modal-footer">
                <div class="form-inline">
                    <div class="input-group">
                        <select id="export-file-word" name="export-file-word" class="form-control mr-2">
                            <option value="png">PNG</option>
                            <option value="pdf">PDF</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" onclick="print('export-file-word','export-word-container')" type="submit">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="/packages/wordcloud/wordcloud2.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        //loader
        $(".loader").toggleClass('d-none');

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

        //Submit Form        
        $("#form-export").validate({
            submitHandler: function(form) {
                var start = moment($("#date-range").data('daterangepicker').startDate._d).format('Y-MM-DD');
                var end = moment($("#date-range").data('daterangepicker').endDate._d).format('Y-MM-DD');
                $("#exportModal").modal("toggle");
                //Modal
                $('#exportModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                $(".loader").toggleClass("d-none");
                $(".close").toggleClass("d-none");
                $(":submit, #export-file").prop("disabled", true);
                $(".modal-title").text("File sedang diproses, mohon tunggu...");

                $.when(
                    getChartData(start, end),
                ).done(function() {
                    $(".loader").toggleClass("d-none");
                    $(":submit, #export-file").prop("disabled", false);
                    $(".close").toggleClass("d-none");
                    $(".modal-title").text("File siap diunduh");
                });
            }
        });

        $("#form-export-word").validate({
            rules: {
                emotion: "required",
            },
            messages: {
                emotion: "Emosi tidak boleh kosong!",
            },
            submitHandler: function(form) {
                var start = moment($("#date-range-word").data('daterangepicker').startDate._d).format('Y-MM-DD');
                var end = moment($("#date-range-word").data('daterangepicker').endDate._d).format('Y-MM-DD');
                var emotion = $("#emotion").val();
                $("#exportWordModal").modal("toggle");
                //Modal
                $('#exportWordModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                getWordCloud(emotion, start, end);
            }
        });
    });

    //Initialize Chart
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

    function getChartData(start, end) {
        //Get data by AJAX        
        var url = "<?= route("chart.read") ?>";
        return $.ajax({
            method: "POST",
            url: url,
            data: {
                startDate: start,
                endDate: end
            },
            success: function(data) {
                $(".fear").text(data.emotion[0].reduce((a, b) => a + b, 0));
                $(".love").text(data.emotion[1].reduce((a, b) => a + b, 0));
                $(".anger").text(data.emotion[2].reduce((a, b) => a + b, 0));
                $(".sadness").text(data.emotion[3].reduce((a, b) => a + b, 0));
                $(".happy").text(data.emotion[4].reduce((a, b) => a + b, 0));

                updateChartData(lineChart, data);
                let startDate = moment(start);
                let endDate = moment(end);
                $(".periode").text(startDate.format("DD/MM/YYYY") + " hingga " + endDate.format("DD/MM/YYYY"));
                $(".last-updated").text(moment().format("DD/MM/YYYY, h:mm:ss a"));
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

    function getWordCloud(emotion, start, end) {
        var url = "<?= route('word.cloud') ?>";
        return $.ajax({
            url: url,
            method: "POST",
            data: {
                emotion: emotion,
                startDate: start,
                endDate: end
            },
            dataType: "json",
            beforeSend: function() {
                //Reset Word Cloud
                $("#export-word-cloud").empty();

                $(".loader").toggleClass("d-none");
                $(".close").toggleClass("d-none");
                $(":submit, #export-file-word").prop("disabled", true);
                $(".modal-title").text("File sedang diproses, mohon tunggu...");
            },
            success: function(data) {
                let exportEmotion = '<div class="card">' +
                    '<div class="card-body">' +
                    '<div id="export-' + emotion + '" class="w-100" style="height:300px"></div>' +
                    '</div>' +
                    '</div>';
                $("#export-word-cloud").append(exportEmotion);
                WordCloud($("#export-" + emotion)[0], {
                    list: data
                });
                $(".loader").toggleClass("d-none");
                $(".modal-title").text("File siap diunduh");
                let startDate = moment(start);
                let endDate = moment(end);
                $(".periode").text(startDate.format("DD/MM/YYYY") + " hingga " + endDate.format("DD/MM/YYYY"));
                $(".last-updated").text(moment().format("DD/MM/YYYY, h:mm:ss a"));
                $(".emotion").text(emotion);
                $(":submit, #export-file-word").prop("disabled", false);
                $(".close").toggleClass("d-none");
            }
        });
    }

    function print(type, container, quality = 2) {
        const filename = 'Report.pdf';
        html2canvas(document.querySelector('#' + container), {
            scale: quality,
            scrollX: 0,
            scrollY: 0
        }).then(canvas => {
            if ($("#" + type).val() == 'png') {
                saveAs(canvas.toDataURL(), 'Report.png');
            } else {
                let height = $('#' + container).height();
                let width = $('#' + container).width();
                let orientation = width > height ? 'l' : 'p';
                let pdf = new jsPDF(orientation, 'px', [width, height]);
                pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, width, height);
                pdf.save(filename);
            }
        });
    }

    function saveAs(uri, filename) {
        var link = document.createElement('a');
        if (typeof link.download === 'string') {
            link.href = uri;
            link.download = filename;

            //Firefox requires the link to be in the body
            document.body.appendChild(link);

            //simulate click
            link.click();

            //remove the link when done
            document.body.removeChild(link);
        } else {
            window.open(uri);
        }
    }
</script>
@endsection