@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card m-b-30">
                <div class="card-body text-center">
                    <div class="form-group">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <b>{{ session('status') }}</b>
                            </div>
                        @endif
                    </div>
                    <div class="form-group"><h1>{{ __("fields.app_name") }}</h1></div>
                    <div class="form-group"><h3>{{ __("fields.app_enterprise_name") }}</h3></div>
                    @if(!is_null($soon))
                        <div class="form-group">
                            <div class="img-responsive img-thumbnail" style="width: 100%; height: 250px">
                                <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                    <img id="visualizar_img"
                                         src="{{ asset('upload/photo_soon/'.$soon->photo) }}"
                                         style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(!is_null($soon))
        <div id="modalPhoto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body" align="center">
                        <div class="img-responsive img-thumbnail" style="width: 75%; height: 275px">
                            <img id="visualizar_img_modal"
                                 src="{{ asset('upload/photo_soon/'.$soon->photo) }}"
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
    @endif
@endsection
