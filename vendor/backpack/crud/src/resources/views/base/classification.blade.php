@extends(backpack_view('blank'))

@section('before_styles')
<style>
    .error {
        color: red;
    }
</style>
@endsection

@section('content')
<h2>
    <span class="text-capitalize">Klasifikasi</span>
</h2>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <form id="form-classification" class="form-horizontal" action="{{ route('classification.process') }}" method="post">
                <div class="card-header"><strong>Klasifikasi</strong> Emosi</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="teks">Teks</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="teks" name="teks" rows="5" placeholder="Teks yang ingin diklasifikasi..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="select1">Model</label>
                        <div class="col-md-9">
                            <select class="form-control" id="model" name="model">
                                <option value="">Pilih model</option>
                                @foreach($models as $model):
                                <option value="{{ $model['model_name'] }}">{{ $model['model_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Klasifikasi</button>
                    <button class="btn btn-sm btn-danger" type="reset"><i class="fa fa-ban"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" id="result">
            <div class="card-header"><strong>Hasil</strong> Klasifikasi</div>
            <div class="card-body">
                <div class="loader">
                    <div class="half-circle-spinner d-flex justify-content-center">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                    <div class="overlay"></div>
                </div>
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="prepro">Hasil Preprocessing</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="prepro" name="prepro" rows="5" placeholder="" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="classification">Klasifikasi</label>
                        <div class="col-md-9">
                            <input class="form-control" id="classification" type="text" name="classification" placeholder="" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('after_scripts')
<script>
    $(document).ready(function() {
        //Loader
        $(".loader").toggleClass('d-none');

        //Form Submit       
        $("#form-classification").validate({
            rules: {
                teks: {
                    required: true,
                    minlength: 100,
                    maxlength: 280
                },
                model: "required",
            },
            messages: {
                teks: {
                    required: "Teks tidak boleh kosong!",
                    minlength: "Panjang teks minimal 100 karakter!",
                    maxlength: "Panjang teks maksimal 280 karakter!"
                },
                model: "Model tidak boleh kosong!",
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader").toggleClass("d-none");
                        $(":submit,:reset").prop("disabled", true);
                        $("html, body").animate({
                            scrollTop: $("#result").offset().top
                        }, 500);
                    },
                    success: function(response) {
                        $(".loader").toggleClass("d-none");
                        $("#prepro").val(response[0]);
                        $("#classification").val(response[1]);
                        $(":submit,:reset").prop("disabled", false);                        
                    }
                });
            }
        });
    });
</script>
@endsection