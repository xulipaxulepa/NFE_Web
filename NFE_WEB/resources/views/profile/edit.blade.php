@extends('layouts.app')

@section('title')- @lang('fields.profile_title_edit') @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                {{ Form::model($profile, ['route' => ['profile.update', $profile], 'method' => 'PUT', 'id' => 'editForm', 'enctype' => 'multipart/form-data']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('birth', __("fields.profile_birth")) }}
                                        {{ Form::date('birth', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('cpf', __("fields.profile_cpf")) }}
                                        {{ Form::text('cpf', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('rg', __("fields.profile_rg")) }}
                                        {{ Form::text('rg', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('phone', __("fields.profile_phone")) }}
                                        {{ Form::text('phone', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('cellphone', __("fields.profile_cellphone")) }}
                                        {{ Form::text('cellphone', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('code_postal', __("fields.profile_code_postal")) }}
                                        {{ Form::text('code_postal', null, ['class'=>'form-control', 'onkeyup'=>'getCodePostal()']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('place', __("fields.profile_place")) }}
                                        {{ Form::text('place', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('number', __("fields.profile_number")) }}
                                        {{ Form::text('number', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('complement', __("fields.profile_complement")) }}
                                        {{ Form::text('complement', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('district', __("fields.profile_district")) }}
                                        {{ Form::text('district', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <br/>
                            <div class="img-responsive img-thumbnail" style="width: 100%; height: 210px">
                                <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                    <img id="visualizar_img"
                                         src="{{ asset(!is_null($profile->photo) ? 'upload/photo_profile/'.$profile->photo : 'sem_imagem.jpg') }}"
                                         style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('city', __("fields.profile_city")) }}
                                {{ Form::text('city', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('state', __("fields.profile_state")) }}
                                {{ Form::text('state', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('photo', __("fields.profile_photo")) }}
                                {{ Form::file('photo', ['class'=>'form-control']) }}
                            </div>
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
                        <img id="visualizar_img_modal"
                             src="{{ asset(!is_null($profile->photo) ? 'upload/photo_profile/'.$profile->photo : 'sem_imagem.jpg') }}"
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
        $("#cpf").mask("999.999.999-99");
        $("#phone").mask("(99) 9999-9999");
        $("#cellphone").mask("(99) 99999-9999");
        $("#code_postal").mask("99999-999");

        function getCodePostal() {
            var code_postal = $("#code_postal").val();
            $.ajax({
                url: "http://viacep.com.br/ws/" + code_postal + "/json/",
                type: "GET",
                dataType: "JSON",
                beforeSend: inicializaPreloader()
            }).done(function (data) {
                finalizaPreloader();
                if (code_postal != "{{ $profile->code_postal }}") {
                    $("#number").val("")
                }
                if (data.uf.length > 0) {
                    $("#state").val(data.uf);
                } else {
                    if (code_postal != "{{ $profile->code_postal }}") {
                        $("#state").val("");
                    }
                }
                if (data.localidade.length > 0) {
                    $("#city").val(data.localidade);
                } else {
                    if (code_postal == "{{ $profile->code_postal }}") {
                        $("#city").val("");
                    }
                }
                if (data.bairro.length > 0) {
                    $("#district").val(data.bairro);
                } else {
                    if (code_postal != "{{ $profile->code_postal }}") {
                        $("#district").val("");
                    }
                }
                if (data.logradouro.length > 0) {
                    $("#place").val(data.logradouro);
                } else {
                    if (code_postal != "{{ $profile->code_postal }}") {
                        $("#place").val("");
                    }
                }
                if (data.complemento.length > 0) {
                    $("#complement").val(data.complemento);
                } else {
                    if (code_postal != "{{ $profile->code_postal }}") {
                        $("#complement").val("");
                    }
                }
            }).fail(function () {
                finalizaPreloader();
            });
        }

        function inicializaPreloader() {
            $(".prelaoder").show();
        }

        function finalizaPreloader() {
            $(".prelaoder").hide();
        }

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

        $("#editForm").validate({
            rules: {
                birth: {
                    max: '{{ date("Y-m-d", strtotime("-18 year")) }}'
                },
                cpf: {
                    maxlength: 25,
                    validation_cpf: true,
                    uniqueCpf: true
                },
                code_postal: {
                    maxlength: 25,
                    validation_code_postal: true
                },
                phone: {
                    maxlength: 25,
                    validation_phone: true
                },
                cellphone: {
                    maxlength: 25,
                    validation_cellphone: true
                },
                place: {
                    maxlength: 255
                },
                number: {
                    maxlength: 255
                },
                complement: {
                    maxlength: 255
                },
                district: {
                    maxlength: 255
                },
                city: {
                    maxlength: 255
                },
                state: {
                    maxlength: 255
                },
                photo: {
                    validateImg: true
                }
            },
            messages: {
                birth: {
                    max: "{{ __("validation_jquery.max_date") }}" + dataAtualFormatada() + "."
                },
                cpf: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_postal: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                phone: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                cellphone: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                place: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                number: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                complement: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                district: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                city: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                state: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("uniqueCpf", function (value, element, config) {
            if (value.length > 0) {
                var status = false;
                $.ajax({
                    type: "POST",
                    url: "{{ url('api/profile_open_cpf') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    async: false,
                    data: {cpf: value},
                    success: function (data) {
                        if (data.data == null || data.data.id == "{{ $profile->id }}") {
                            status = true;
                        }
                    }, error: function (data) {
                        console.log("ERROR SERVER")
                    }
                });
                return status;
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.unique") }}");

        jQuery.validator.addMethod("validation_cpf", function (value, element, config) {
            if (value.length > 0) {
                return validateInput("CPF", value);
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.value_invalid") }}");

        jQuery.validator.addMethod("validation_code_postal", function (value, element, config) {
            return validateInput("CODE_POSTAL", value);
        }, "{{ __("validation_jquery.value_invalid") }}");

        jQuery.validator.addMethod("validation_phone", function (value, element, config) {
            return validateInput("PHONE", value);
        }, "{{ __("validation_jquery.value_invalid") }}");

        jQuery.validator.addMethod("validation_cellphone", function (value, element, config) {
            return validateInput("CELLPHONE", value);
        }, "{{ __("validation_jquery.value_invalid") }}");

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

        function validateInput(type, value) {
            if (type == "CPF") {
                return validate_cpf(value)
            } else if (type == "CODE_POSTAL") {
                if (value.length == 0) {
                    return true;
                } else if (value.length == 9) {
                    var newValue = "", traceCount = 0;
                    for (var v = 0; v < value.length; v++) {
                        if ($.isNumeric(value[v])) {
                            newValue += value[v];
                        } else if (value[v] == "-") {
                            traceCount++;
                        }
                    }
                    if (traceCount == 1 && newValue.length == 8) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else if (type == "PHONE") {
                if (value.length == 0) {
                    return true;
                } else if (value.length == 14) {
                    var newValue = "", parenthesisCount = 0, traceCount = 0;
                    for (var v = 0; v < value.length; v++) {
                        if ($.isNumeric(value[v])) {
                            newValue += value[v];
                        } else if (value[v] == "(" || value[v] == ")") {
                            parenthesisCount++;
                        } else if (value[v] == "-") {
                            traceCount++;
                        }
                    }
                    if (parenthesisCount == 2 && traceCount == 1 && newValue.length == 10) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else if (type == "CELLPHONE") {
                if (value.length == 0) {
                    return true;
                } else if (value.length == 15) {
                    var newValue = "", parenthesisCount = 0, traceCount = 0;
                    for (var v = 0; v < value.length; v++) {
                        if ($.isNumeric(value[v])) {
                            newValue += value[v];
                        } else if (value[v] == "(" || value[v] == ")") {
                            parenthesisCount++;
                        } else if (value[v] == "-") {
                            traceCount++;
                        }
                    }
                    if (parenthesisCount == 2 && traceCount == 1 && newValue.length == 11) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        function validate_cpf(value) {
            value = value.toString();
            value = value.replace(/[^0-9]/g, '');
            if (value == "11111111111" || value == "22222222222" || value == "33333333333" || value == "44444444444" || value == "55555555555" || value == "66666666666" || value == "77777777777" || value == "88888888888" || value == "99999999999") {
                return false;
            } else {
                var digits = value.substr(0, 9);
                var new_cpf = calc_digits_positions(digits);
                var new_cpf = calc_digits_positions(new_cpf, 11);
                if (new_cpf === value) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        function calc_digits_positions(digits, positions = 10, sum_digits = 0) {

            digits = digits.toString();

            for (var i = 0; i < digits.length; i++) {
                sum_digits = sum_digits + (digits[i] * positions);

                positions--;

                if (positions < 2) {
                    positions = 9;
                }
            }

            sum_digits = sum_digits % 11;

            if (sum_digits < 2) {
                sum_digits = 0;
            } else {
                sum_digits = 11 - sum_digits;
            }

            var cpf = digits + sum_digits;

            return cpf;

        }

        function dataAtualFormatada() {
            var date = "{{ date("Y-m-d", strtotime("-18 year")) }}";
            return (date[8] + date[9]) + "/" + (date[5] + date[6]) + "/" + (date[0] + date[1] + date[2] + date[3]);
        }
    </script>
@endsection