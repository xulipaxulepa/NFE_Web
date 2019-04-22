@extends('layouts.app')

@section('title')- @lang('fields.profile_title_show') #{{ $profile->id }} @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_birth")) }}
                                        {{ Form::text('', $profile->birth, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_cpf")) }}
                                        {{ Form::text('', $profile->cpf, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_rg")) }}
                                        {{ Form::text('', $profile->rg, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_phone")) }}
                                        {{ Form::text('', $profile->phone, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_cellphone")) }}
                                        {{ Form::text('', $profile->cellphone, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_code_postal")) }}
                                        {{ Form::text('', $profile->code_postal, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_place")) }}
                                        {{ Form::text('', $profile->place, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_number")) }}
                                        {{ Form::text('', $profile->number, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_complement")) }}
                                        {{ Form::text('', $profile->complement, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_district")) }}
                                        {{ Form::text('', $profile->district, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_city")) }}
                                        {{ Form::text('', $profile->city, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.profile_state")) }}
                                        {{ Form::text('', $profile->state, ['class' => 'form-control', 'disabled' => true]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-footer">@lang("fields.profile_photo")</div>
                                <div class="panel-body">
                                    <div class="img-responsive img-thumbnail" style="width: 100%; height: 210px">
                                        <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                            <img id="visualizar_img"
                                                 src="{{ asset(!is_null($profile->photo) ? 'upload/photo_profile/'.$profile->photo : 'sem_imagem.jpg') }}"
                                                 style="height: 100%; width: 100%"
                                                 class="img-responsive img-thumbnail"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('user') }}" class="btn btn-secondary waves-effect waves-light">
                        @lang("fields.btn_back")
                    </a>
                </div>
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