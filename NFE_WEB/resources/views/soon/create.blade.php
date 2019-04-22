@extends('layouts.app')

@section('title')- @lang('fields.soon_title_register') @endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card m-b-30">
                {{ Form::open(['url' => 'soon', 'method' => 'POST', 'id' => 'registerForm', 'enctype' => 'multipart/form-data']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="form-group">
                        {{ Form::label('photo', __("fields.soon_photo")."*") }}
                        {{ Form::file('photo', ['class'=>'form-control']) }}
                    </div>
                    <div class="form-group">
                        <div class="img-responsive img-thumbnail" style="width: 100%; height: 210px">
                            <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                <img id="visualizar_img" src="{{ asset('sem_imagem.jpg') }}"
                                     style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        @lang("fields.btn_save")
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="modalPhoto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" align="center">
                    <div class="img-responsive img-thumbnail" style="width: 75%; height: 275px">
                        <img id="visualizar_img_modal" src="{{ asset('sem_imagem.jpg') }}"
                             style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#visualizar_img').attr('src', e.target.result);
                    $('#visualizar_img_modal').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function () {
            readURL(this);
        });

        $("#registerForm").validate({
            rules: {
                photo: {
                    required: true,
                    validateImg: true
                }
            },
            messages: {
                photo: {
                    required: "{{ __("validation_jquery.required") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("validateImg", function (value, element, config) {
            if (value.length > 0) {
                var status = false, extension = "", point = false;
                for (var i = 0; i < value.length; i++) {
                    if (point) {
                        extension += value[i];
                    }
                    if (value[i] == ".") {
                        point = true;
                    }
                }
                if (extension == "png" || extension == "jpeg" || extension == "jpg" || extension == "gif" || extension == "PNG" || extension == "JPEG" || extension == "JPG" || extension == "GIF") {
                    status = true;
                }
                return status;
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.valid_img") }}");
    </script>
@endsection