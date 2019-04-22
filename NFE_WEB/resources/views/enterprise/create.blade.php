@extends('layouts.app')

@section('title')- @lang('fields.enterprise_title_register') @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                {{ Form::open(['url' => 'enterprise', 'method' => 'POST', 'id' => 'registerForm', 'enctype' => 'multipart/form-data']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('cnpj', __("fields.enterprise_cnpj").'*') }}
                                {{ Form::text('cnpj', null, ['class'=>'form-control', 'autofocus' => true, 'onkeyup'=>'getCnpj()']) }}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('social_name', __("fields.enterprise_social_name")) }}
                                {{ Form::text('social_name', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('fantasy_name', __("fields.enterprise_fantasy_name")) }}
                                {{ Form::text('fantasy_name', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('tax_regime', __("fields.enterprise_tax_regime").'*') }}
                                {{ Form::select('tax_regime', $taxs, null, ['class'=>'form-control', 'placeholder'=>'']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('state_registration', __("fields.enterprise_state_registration").'*') }}
                                {{ Form::text('state_registration', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('legal_nature', __("fields.enterprise_legal_nature").'*') }}
                                {{ Form::text('legal_nature', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('phone', __("fields.enterprise_phone")) }}
                                {{ Form::text('phone', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('cellphone', __("fields.enterprise_cellphone")) }}
                                {{ Form::text('cellphone', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('code_postal', __("fields.enterprise_code_postal").'*') }}
                                        {{ Form::text('code_postal', null, ['class'=>'form-control', 'onkeyup'=>'getCodePostal()']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('place', __("fields.enterprise_place").'*') }}
                                        {{ Form::text('place', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('number', __("fields.enterprise_number").'*') }}
                                        {{ Form::text('number', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('complement', __("fields.enterprise_complement")) }}
                                        {{ Form::text('complement', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('district', __("fields.enterprise_district").'*') }}
                                        {{ Form::text('district', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('code_city', __("fields.enterprise_code_city").'*') }}
                                        {{ Form::text('code_city', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {{ Form::label('city', __("fields.enterprise_city").'*') }}
                                        {{ Form::text('city', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('code_state', __("fields.enterprise_code_state").'*') }}
                                        {{ Form::text('code_state', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('state', __("fields.enterprise_state").'*') }}
                                        {{ Form::text('state', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('certified', __("fields.enterprise_certified").'*') }}
                                        {{ Form::file('certified', ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('password_certified', __("fields.enterprise_password_certified").'*') }}
                                        {{ Form::text('password_certified', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('photo', __("fields.enterprise_photo")) }}
                                {{ Form::file('photo', ['class'=>'form-control']) }}
                            </div>
                            <div class="img-responsive img-thumbnail" style="width: 100%; height: 145px">
                                <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                    <img id="visualizar_img" src="{{ asset('sem_imagem.jpg') }}"
                                         style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        @lang("fields.btn_save")
                    </button>
                    @if(\App\Model\Enterprise::where('user', Auth::id())->count() > 0)
                        <a href="{{ url('enterprise') }}" class="btn btn-secondary waves-effect waves-light pull-right">
                            @lang("fields.btn_back")
                        </a>
                    @endif
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
        function getCnpj() {
            var cnpj = "";
            var cnpjVar = $("#cnpj").val();
            for (var i = 0; i < cnpjVar.length; i++) {
                if ($.isNumeric(cnpjVar[i])) {
                    cnpj += cnpjVar[i]
                }
            }
            $.ajax({
                url: "https://legalentity.api.nfe.io/v1/legalentities/basicInfo/" + cnpj,
                type: "GET",
                dataType: "JSON",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        "Accept", "application/json"
                    );
                    xhr.setRequestHeader(
                        "Authorization", "ox9c30whmV7A6b9Geoss6pQUlAyeFIZugW2qFMJCu4rB1IMxLf8HF2rEBBKZoOqEdXb"
                    );
                },
            }).done(function (data) {
                if (data.tradeName != null && data.tradeName.length > 0) {
                    $("#social_name").val(data.tradeName);
                }
                if (data.name != null && data.name.length > 0) {
                    $("#fantasy_name").val(data.name);
                }
                if (data.legalNature != null && data.legalNature.description != null && data.legalNature.description.length > 0) {
                    $("#legal_nature").val(data.legalNature.description);
                }
                if (data.phones != null && data.phones.length > 0) {
                    if (data.phones[0].number.length == 8) {
                        var phone = "(" + data.phones[0].ddd + ") ";
                        for (var t = 0; t < data.phones[0].number.length; t++) {
                            phone += data.phones[0].number[t]
                            if (t == 3) {
                                phone += "-";
                            }
                        }
                        $("#phone").val(phone);
                    } else {
                        var cellphone = "(" + data.phones[0].ddd + ") ";
                        for (var c = 0; c < data.phones[0].number.length; c++) {
                            cellphone += data.phones[0].number[c];
                            if (c == 3) {
                                cellphone += "-";
                            }
                        }
                        $("#cellphone").val(cellphone);
                    }
                }
                if (data.address != null && data.address.number != null && data.address.number.length > 0) {
                    $("#number").val(data.address.number);
                }
                if (data.address != null && data.address.postalCode != null && data.address.postalCode.length > 0) {
                    $("#code_postal").val(data.address.postalCode);
                }
                if (data.address != null && data.address.street != null && data.address.street.length > 0) {
                    $("#place").val(data.address.streetSuffix + " " + data.address.street);
                }
                if (data.address != null && data.address.district != null && data.address.district.length > 0) {
                    $("#district").val(data.address.district);
                }
                if (data.address != null && data.address.city != null && data.address.city.name.length > 0) {
                    $("#city").val(data.address.city.name);
                }
                if (data.address != null && data.address.city != null && data.address.city.code.length > 0) {
                    $("#code_city").val(data.address.city.code);
                }
                if (data.address != null && data.address.state != null && data.address.state.length > 0) {
                    var uf = data.address.state;
                    $("#state").val(data.address.state);
                    $.ajax({
                        url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/",
                        type: "GET",
                        dataType: "JSON",
                    }).done(function (dataSTATE) {
                        for (var d = 0; d < dataSTATE.length; d++) {
                            if (dataSTATE[d].sigla == uf) {
                                $("#code_state").val(dataSTATE[d].id)
                                break;
                            }
                        }
                    });
                }
            });
        }

        $("#cnpj").mask("99.999.999/9999-99");
        $("#phone").mask("(99) 9999-9999");
        $("#cellphone").mask("(99) 99999-9999");
        $("#code_postal").mask("99999-999");

        function getCodePostal() {
            var code_postal = $("#code_postal").val();
            var uf = '';
            $.ajax({
                url: "http://viacep.com.br/ws/" + code_postal + "/json/",
                type: "GET",
                dataType: "JSON",
                beforeSend: inicializaPreloader()
            }).done(function (data) {
                finalizaPreloader();
                if (data.uf.length > 0) {
                    $("#state").val(data.uf);
                } else {
                    $("#state").val("");
                }
                if (data.localidade.length > 0) {
                    $("#city").val(data.localidade);
                } else {
                    $("#city").val("");
                }
                if (data.bairro.length > 0) {
                    $("#district").val(data.bairro);
                } else {
                    $("#district").val("");
                }
                if (data.logradouro.length > 0) {
                    $("#place").val(data.logradouro);
                } else {
                    $("#place").val("");
                }
                if (data.complemento.length > 0) {
                    $("#complement").val(data.complemento);
                } else {
                    $("#complement").val("");
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
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function () {
            readURL(this);
        });

        $("#registerForm").validate({
            rules: {
                cnpj: {
                    required: true,
                    maxlength: 25,
                    validation_cnpj: true,
                    uniqueCnpj: true
                },
                social_name: {
                    maxlength: 255
                },
                fantasy_name: {
                    maxlength: 255
                },
                tax_regime: {
                    required: true
                },
                state_registration: {
                    required: true,
                    maxlength: 255
                },
                legal_nature: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    maxlength: 25,
                    validation_phone: true
                },
                cellphone: {
                    maxlength: 25,
                    validation_cellphone: true
                },
                code_postal: {
                    required: true,
                    maxlength: 25,
                    validation_code_postal: true
                },
                place: {
                    required: true,
                    maxlength: 255
                },
                number: {
                    required: true,
                    maxlength: 255
                },
                complement: {
                    maxlength: 255
                },
                district: {
                    required: true,
                    maxlength: 255
                },
                code_city: {
                    required: true,
                    maxlength: 25
                },
                city: {
                    required: true,
                    maxlength: 255
                },
                code_state: {
                    required: true,
                    maxlength: 25
                },
                state: {
                    required: true,
                    maxlength: 255
                },
                certified: {
                    required: true
                },
                password_certified: {
                    required: true,
                    maxlength: 255
                },
                photo: {
                    validateImg: true
                }
            },
            messages: {
                cnpj: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                social_name: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                fantasy_name: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                tax_regime: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                state_registration: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                legal_nature: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                phone: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                cellphone: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_postal: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                place: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                number: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                complement: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                district: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_city: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                city: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_state: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                state: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                certified: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                password_certified: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("uniqueCnpj", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/enterprise_open_cnpj') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {cnpj: value},
                success: function (data) {
                    if (data.data == null) {
                        status = true;
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        jQuery.validator.addMethod("validation_cnpj", function (value, element, config) {
            return validateInput("CNPJ", value);
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
            if (type == "CNPJ") {
                value = value.replace(/[^\d]+/g, '');
                if (value == '') {
                    return false;
                }
                if (value.length != 14) {
                    return false;
                }
                if (value == "00000000000000" || value == "11111111111111" || value == "22222222222222" || value == "33333333333333" || value == "44444444444444" || value == "55555555555555" || value == "66666666666666" || value == "77777777777777" || value == "88888888888888" || value == "99999999999999") {
                    return false;
                }
                sizeValue = value.length - 2
                number = value.substring(0, sizeValue);
                digits = value.substring(sizeValue);
                sum = 0;
                pos = sizeValue - 7;
                for (i = sizeValue; i >= 1; i--) {
                    sum += number.charAt(sizeValue - i) * pos--;
                    if (pos < 2) {
                        pos = 9;
                    }
                }
                result = sum % 11 < 2 ? 0 : 11 - sum % 11;
                if (result != digits.charAt(0)) {
                    return false;
                }
                sizeValue = sizeValue + 1;
                number = value.substring(0, sizeValue);
                sum = 0;
                pos = sizeValue - 7;
                for (i = sizeValue; i >= 1; i--) {
                    sum += number.charAt(sizeValue - i) * pos--;
                    if (pos < 2) {
                        pos = 9;
                    }
                }
                result = sum % 11 < 2 ? 0 : 11 - sum % 11;
                if (result != digits.charAt(1)) {
                    return false;
                }
                return true;
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
    </script>
@endsection