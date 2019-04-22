@extends('layouts.app')

@section('title')- @lang('fields.enterprise_title_show') #{{ $enterprise->id }} @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                {{ Form::open(['url' => 'enterprise', 'method' => 'POST', 'id' => 'registerForm', 'enctype' => 'multipart/form-data']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_social_name")) }}
                                {{ Form::text('', $enterprise->social_name, ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_fantasy_name")) }}
                                {{ Form::text('', $enterprise->fantasy_name, ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_tax_regime")) }}
                                {{ Form::text('', $enterprise->getTaxRegimeSTR(), ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_state_registration")) }}
                                {{ Form::text('', $enterprise->state_registration, ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_legal_nature")) }}
                                {{ Form::text('', $enterprise->legal_nature, ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_phone")) }}
                                {{ Form::text('', $enterprise->phone, ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('', __("fields.enterprise_cellphone")) }}
                                {{ Form::text('', $enterprise->cellphone, ['class'=>'form-control', 'disabled'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_code_postal")) }}
                                        {{ Form::text('', $enterprise->code_postal, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_place")) }}
                                        {{ Form::text('', $enterprise->place, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_number")) }}
                                        {{ Form::text('', $enterprise->number, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_complement")) }}
                                        {{ Form::text('', $enterprise->complement, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_district")) }}
                                        {{ Form::text('', $enterprise->district, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_code_city")) }}
                                        {{ Form::text('', $enterprise->code_city, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_city")) }}
                                        {{ Form::text('', $enterprise->city, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_code_state")) }}
                                        {{ Form::text('', $enterprise->code_state, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('', __("fields.enterprise_state")) }}
                                        {{ Form::text('', $enterprise->state, ['class'=>'form-control', 'disabled'=>true]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="img-responsive img-thumbnail" style="width: 100%; height: 155px">
                                    <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                        <img id="visualizar_img"
                                             src="{{ asset(!is_null($enterprise->photo) ? 'upload/photo_enterprise/'.$enterprise->photo : 'sem_imagem.jpg') }}"
                                             style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->permissionBoolean('ROLE_ADMIN'))
                    <div class="card-footer text-right">
                        <a href="{{ url('enterprise') }}" class="btn btn-secondary waves-effect waves-light">
                            @lang("fields.btn_back")
                        </a>
                    </div>
                @endif
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
                             src="{{ asset(!is_null($enterprise->photo) ? 'upload/photo_enterprise/'.$enterprise->photo : 'sem_imagem.jpg') }}"
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