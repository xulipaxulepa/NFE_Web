@extends('layouts.app')

@section('title')- @lang('fields.note_title_register') @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                {{ Form::open(['url' => 'note', 'method' => 'POST', 'id' => 'registerFormGeneral', 'enctype' => 'multipart/form-data']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="card">
                                <div class="card-header font-weight-bold">@lang("fields.note_title_register_nature_option")</div>
                                <div class="card-body">
                                    @include('layouts.flashMessages')
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('nature_option', __("fields.note_nature_option").'*') }}
                                                {{ Form::text('nature_option', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('base_icms', __("fields.note_base_icms_subst")) }}
                                                {{ Form::text('base_icms', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('value_icms', __("fields.note_icms_subst")) }}
                                                {{ Form::text('value_icms', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('price_secure', __("fields.note_secure")) }}
                                                {{ Form::text('price_secure', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('price_off', __("fields.note_off")) }}
                                                {{ Form::text('price_off', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('price_accessory', __("fields.note_expense")) }}
                                                {{ Form::text('price_accessory', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('price_freight', __("fields.note_freight")) }}
                                                {{ Form::text('price_freight', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('type_freight', __("fields.note_type_freight").'*') }}
                                                {{ Form::select('type_freight', $freight, null, ['class'=>'form-control', 'placeholder' => '']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('register_freight', __("fields.note_cnpj_cpf")) }}
                                                {{ Form::text('register_freight', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('shipping_company', __("fields.note_shipping_company")) }}
                                                {{ Form::text('shipping_company', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('place_shipping_company', __("fields.note_place_shipping_company")) }}
                                                {{ Form::text('place_shipping_company', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('city_shipping_company', __("fields.note_city_shipping_company")) }}
                                                {{ Form::text('city_shipping_company', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('state_freight', __("fields.note_state_freight")) }}
                                                {{ Form::text('state_freight', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('amount_freight', __("fields.note_amount_freight")) }}
                                                {{ Form::text('amount_freight', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('specie', __("fields.note_specie")) }}
                                                {{ Form::text('specie', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="card">
                                <div class="card-header font-weight-bold">@lang("fields.note_title_register_sender")</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('social_name_sender', __("fields.note_social_name_sender").'*') }}
                                                {{ Form::text('social_name_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('state_register_sender', __("fields.note_state_register_sender")) }}
                                                {{ Form::text('state_register_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('register_sender', __("fields.note_register_sender").'*') }}
                                                {{ Form::text('register_sender', null, ['class'=>'form-control', 'onkeyup'=>'getCnpjSender()']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('code_postal_sender', __("fields.note_code_postal_sender").'*') }}
                                                {{ Form::text('code_postal_sender', null, ['class'=>'form-control', 'onkeyup'=>'getCodePostalSender()']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('place_sender', __("fields.note_place_sender").'*') }}
                                                {{ Form::text('place_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('number_sender', __("fields.note_number_sender").'*') }}
                                                {{ Form::text('number_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('complement_sender', __("fields.note_complement_sender")) }}
                                                {{ Form::text('complement_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{ Form::label('district_sender', __("fields.note_district_sender").'*') }}
                                                {{ Form::text('district_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('code_city_sender', __("fields.note_code_city_sender").'*') }}
                                                {{ Form::text('code_city_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {{ Form::label('city_sender', __("fields.note_city_sender").'*') }}
                                                {{ Form::text('city_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {{ Form::label('code_state_sender', __("fields.note_code_state_sender").'*') }}
                                                {{ Form::text('code_state_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('state_sender', __("fields.note_state_sender").'*') }}
                                                {{ Form::text('state_sender', null, ['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header font-weight-bold">@lang("fields.note_title_register_product")</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-success" onclick="allProduct()"
                                                        type="button">@lang("fields.note_insert_item")</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>@lang("fields.note_product")</th>
                                                    <th width="100px">@lang("fields.note_amount_product")</th>
                                                    <th width="100px">@lang("fields.note_price_product")</th>
                                                    <th width="100px">@lang("fields.note_cst_product")</th>
                                                    <th width="50px"></th>
                                                </tr>
                                                </thead>
                                                <tbody id="bodyItem"></tbody>
                                            </table>
                                            <input type="hidden" name="amountItem" id="amountItem" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header font-weight-bold">@lang("fields.note_enterprise")</div>
                                <div class="card-body">
                                    <div class="img-responsive img-thumbnail" style="width: 100%; height: 190px">
                                        <a href="#" data-toggle="modal" data-target="#modalPhotoEnterprise">
                                            <img id="visualizar_img"
                                                 src="{{ asset(!is_null(Session::get('enterprise')->photo) ? 'upload/photo_enterprise/'.Session::get('enterprise')->photo : 'sem_imagem.jpg') }}"
                                                 style="height: 100%; width: 100%"
                                                 class="img-responsive img-thumbnail"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        @lang("fields.btn_issue")
                    </button>
                    <a href="{{ url('note') }}" class="btn btn-secondary waves-effect waves-light pull-right">
                        @lang("fields.btn_back")
                    </a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="modalProducts" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.product_title_index")</h4>
                </div>
                <div class="modal-body">
                    <h4 class="mt-0 header-title">
                        <button type="button" onclick="newProduct()"
                                class="btn btn-sm btn-success">@lang('fields.btn_register_new')</button>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i
                                            class="fa fa-eraser"></i>
                                </button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="productTABLE"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalUpdateProduct" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleUpdateProduct"></h4>
                </div>
                {{ Form::open(['url' => '#', 'id' => 'updateSingleProductForm']) }}
                <div class="modal-body">
                    {{ Form::hidden('product_single_id', null, ['id' => 'product_single_id']) }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('name_single_product', __("fields.product_name").'*') }}
                                {{ Form::text('name_single_product', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('value_single_product', __("fields.product_value").'*') }}
                                {{ Form::text('value_single_product', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('price_single_product', __("fields.product_price").'*') }}
                                {{ Form::text('price_single_product', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('ncm_single_product', __("fields.product_ncm").'*') }}
                                <div class="input-group">
                                    {{ Form::text('ncm_str_single_product', null, ['id' => 'ncm_str_single_product', 'class'=>'form-control', 'style'=>'margin-right: 3px', 'readonly' => true]) }}
                                    {{ Form::hidden('ncm_single_product', null, ['id'=>'ncm_single_product']) }}
                                    <button type="button" onclick="allNcm()"
                                            class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('cfop_single_product', __("fields.product_cfop").'*') }}
                                <div class="input-group">
                                    {{ Form::text('cfop_str_single_product', null, ['id' => 'cfop_str_single_product', 'class'=>'form-control', 'style'=>'margin-right: 3px', 'readonly' => true]) }}
                                    {{ Form::hidden('cfop_single_product', null, ['id'=>'cfop_single_product']) }}
                                    <button type="button" onclick="allCfop()"
                                            class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('aliquota_single_product', __("fields.product_aliquota").'*') }}
                                {{ Form::text('aliquota_single_product', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('ipi_single_product', __("fields.product_ipi").'*') }}
                                {{ Form::text('ipi_single_product', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('unit_single_product', __("fields.product_unit").'*') }}
                                {{ Form::text('unit_single_product', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang("fields.btn_save")
                    </button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNcm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.ncm_title_index")</h4>
                </div>
                <div class="modal-body">
                    <h4 class="mt-0 header-title">
                        <button type="button" onclick="newNcm()"
                                class="btn btn-sm btn-success">@lang('fields.btn_register_new')</button>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="ncmTABLE">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNcmUpdate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {{ Form::open(['url' => '#', 'id' => 'updateForm']) }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleUpdateNcm"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('ncm_id', null, ['id' => 'ncm_id']) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('ncm_code', __("fields.ncm_code")."*") }}
                                {{ Form::text('ncm_code', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                {{ Form::label('ncm_description', __("fields.ncm_description")) }}
                                {{ Form::text('ncm_description', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('ncm_ipi', __("fields.ncm_ipi")) }}
                                {{ Form::text('ncm_ipi', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">@lang("fields.btn_save")</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="modal fade" id="modalCfop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.cfop_title_index")</h4>
                </div>
                <div class="modal-body">
                    <h4 class="mt-0 header-title">
                        <button type="button" onclick="newCfop()"
                                class="btn btn-sm btn-success">@lang('fields.btn_register_new')</button>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="cfopTABLE">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCfopUpdate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {{ Form::open(['url' => '#', 'id' => 'updateForm']) }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleUpdateCfop"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('cfop_id', null, ['id' => 'cfop_id']) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('cfop_code', __("fields.cfop_code")."*") }}
                                {{ Form::text('cfop_code', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{ Form::label('cfop_description', __("fields.cfop_description")."*") }}
                                {{ Form::text('cfop_description', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">@lang("fields.btn_save")</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="modal fade" id="modalAmount" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.note_insert_item")</h4>
                </div>
                {{ Form::open(['url' => '#', 'id' => 'registerForm']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                {{ Form::label('itemModal_str', __("fields.note_product")."*", ['class' => 'control-label']) }}
                                {{ Form::text('itemModal_str', null, ['id' => 'itemModal_str', 'class' => 'form-control', 'readonly' => true]) }}
                                {{ Form::hidden('itemModal', null, ['id' => 'itemModal']) }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('priceModal_str', __("fields.note_price_product")."*", ['class' => 'control-label']) }}
                                {{ Form::text('priceModal_str', null, ['id' => 'priceModal_str', 'class' => 'form-control', 'readonly' => true]) }}
                                {{ Form::hidden('priceModal', null, ['id' => 'priceModal']) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{ Form::label('cst_str', __("fields.note_cst_product")."*", ['class' => 'control-label']) }}
                                <div class="input-group">
                                    {{ Form::text('cst_str', null, ['id' => 'cst_str', 'class'=>'form-control', 'style'=>'margin-right: 3px', 'readonly' => true]) }}
                                    {{ Form::hidden('cst', null, ['id'=>'cst']) }}
                                    <button type="button" onclick="allCst()" class="btn btn-success btn-sm"><i
                                                class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('amount', __("fields.note_amount_product")."*", ['class' => 'control-label']) }}
                                {{ Form::text('amount', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="insert" class="btn btn-primary">@lang("fields.btn_insert")
                    </button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCst" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.cst_title_index")</h4>
                </div>
                <div class="modal-body">
                    <h4 class="mt-0 header-title">
                        <button type="button" onclick="newCst()"
                                class="btn btn-sm btn-success">@lang('fields.btn_register_new')</button>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="cstTABLE">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCstUpdate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {{ Form::open(['url' => '#', 'id' => 'updateForm']) }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleUpdateCst"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('cst_id', null, ['id' => 'cst_id']) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('cst_code', __("fields.cst_code")."*") }}
                                {{ Form::text('cst_code', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{ Form::label('cst_description', __("fields.cst_description")) }}
                                {{ Form::text('cst_description', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">@lang("fields.btn_save")</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <div id="modalPhotoEnterprise" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" align="center">
                    <div class="img-responsive img-thumbnail" style="width: 75%; height: 275px">
                        <img id="visualizar_img_modal"
                             src="{{ asset(!is_null(Session::get('enterprise')->photo) ? 'upload/photo_enterprise/'.Session::get('enterprise')->photo : 'sem_imagem.jpg') }}"
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
        var pageNcm = '';
        var searchNcm = '';

        $(document).on('click', '#modalNcm .pagination a', function (e) {
            e.preventDefault();
            pageNcm = $(this).attr('href').split('page=')[1];
            searchNcm = $("#modalNcm #search_text").val();
            allNcm()
        });

        $(document).on('keyup', '#modalNcm #search_text', function (e) {
            pageNcm = '';
            searchNcm = $("#modalNcm #search_text").val();
            allNcm()
        });

        $(document).on('click', '#modalNcm #btnEraser', function (e) {
            pageNcm = '';
            searchNcm = '';
            allNcm()
        });

        function allNcm() {
            if(searchNcm == null ||searchNcm.length == 0) {
                $("#modalNcm #search_text").val("")
                $("#modalNcm #btnEraser").hide();
            } else {
                $("#modalNcm #btnEraser").show();
            }
            $("#modalNcm").modal('show')

            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_all_select') }}?page=" + pageNcm,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    search: searchNcm,
                    select: 'product.ncm_table',
                    enterprise: '{{ Session::get('enterprise')->id }}'
                },
                success: function (data) {
                    if (data.count == 0 && pageNcm != '' && parseInt(pageNcm) > 1) {
                        pageNcm = parseInt(pageNcm) - 1;
                        allNcm();
                    } else {
                        $("#modalNcm #ncmTABLE").html(data.html);
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function openNcm(ncm) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: ncm, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalNcm").modal('hide')
                    $('#ncm_str_single_product').val(data.data.code + ((data.data.description != null && data.data.description.length > 0) ? " - " + data.data.description : ""))
                    $('#ncm_single_product').val(data.data.id)
                    $('#ipi_single_product').val(data.data.ipi != null ? data.data.ipi : 0)
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function newNcm() {
            $("#ncm_id").val("");
            $("#ncm_code").val("");
            $("#ncm_description").val("");
            $("#ncm_ipi").val("");
            $("#titleUpdateNcm").html("{{ __("fields.ncm_title_register") }}");
            $("#modalNcmUpdate").modal('show');
        }

        jQuery.validator.addMethod("uniqueNcmCode", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_open_code') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    code: value,
                    enterprise: "{{ Session::get('enterprise')->id }}"
                },
                success: function (data) {
                    var id = $("#ncm_id").val();
                    if (id == null || (id != null && id.length == 0)) {
                        if (data.data == null) {
                            status = true;
                        }
                    } else {
                        if (data.data == null || data.data.id == id) {
                            status = true;
                        }
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        $("#modalNcmUpdate #updateForm").validate({
            rules: {
                ncm_code: {
                    required: true,
                    maxlength: 25,
                    uniqueNcmCode: true
                },
                ncm_description: {
                    maxlength: 255
                },
                ncm_ipi: {
                    validateDigits: true
                }
            },
            messages: {
                ncm_code: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                ncm_description: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var id = $("#ncm_id").val();
                var code = $("#ncm_code").val();
                var description = $("#ncm_description").val();
                var ipi = $("#ncm_ipi").val();
                if (id == null || (id != null && id.length == 0)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/ncm_store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            code: code,
                            description: description,
                            ipi: ipi,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openNcm(data.data.id)
                            $("#modalNcmUpdate").modal('hide');
                            $("#modalNcm").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/ncm_update') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            id: id,
                            code: code,
                            description: description,
                            ipi: ipi,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openNcm(data.data.id)
                            $("#modalNcmUpdate").modal('hide');
                            $("#modalNcm").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                }
            }
        });

        function openTrashNcm(ncm) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('api/ncm_destroy') }}',
                    async: false,
                    data: {id: ncm, enterprise: "{{ Session::get('enterprise')->id }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            if (ncm == $("#ncm_single_product").val()) {
                                $("#ncm_str_single_product").val("")
                                $("#ncm_single_product").val("")
                            }
                            allNcm();
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function openEditNcm(ncm) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: ncm, enterprise: "{{ Session::get('enterprise')->id }}"},
                success: function (data) {
                    $("#modalNcmUpdate #ncm_id").val(data.data.id);
                    $("#modalNcmUpdate #ncm_code").val(data.data.code);
                    $("#modalNcmUpdate #ncm_description").val(data.data.description);
                    $('#modalNcmUpdate #ncm_ipi').val(data.data.ipi != null ? data.data.ipi : 0)
                    $("#modalNcmUpdate #titleUpdateNcm").html("{{ __("fields.ncm_title_edit") }} #" + data.data.id);
                    $("#modalNcmUpdate").modal('show');
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        var pageCfop = '';
        var searchCfop = '';

        $(document).on('click', '#modalCfop .pagination a', function (e) {
            e.preventDefault();
            pageCfop = $(this).attr('href').split('page=')[1];
            searchCfop = $("#modalCfop #search_text").val();
            allCfop();
        });

        $(document).on('keyup', '#modalCfop #search_text', function (e) {
            pageCfop = '';
            searchCfop = $("#modalCfop #search_text").val();
            allCfop();
        });

        $(document).on('click', '#modalCfop #btnEraser', function (e) {
            pageCfop = '';
            searchCfop = '';
            allCfop()
        });

        function allCfop() {
            if(searchCfop == null ||searchCfop.length == 0) {
                $("#modalCfop #search_text").val("");
                $("#modalCfop #btnEraser").hide();
            } else {
                $("#modalCfop #btnEraser").show();
            }
            $("#modalCfop").modal('show')

            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_all_select') }}?page=" + pageCfop,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    search: searchCfop,
                    select: 'product.cfop_table',
                    enterprise: '{{ Session::get('enterprise')->id }}'
                },
                success: function (data) {
                    if (data.count == 0 && pageCfop != '' && parseInt(pageCfop) > 1) {
                        pageCfop = parseInt(pageCfop) - 1;
                        allCfop();
                    } else {
                        $("#modalCfop #cfopTABLE").html(data.html)
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function openCfop(cfop) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: cfop, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalCfop").modal('hide')
                    $('#cfop_str_single_product').val(data.data.code + ((data.data.description != null && data.data.description.length > 0) ? " - " + data.data.description : ""))
                    $('#cfop_single_product').val(data.data.id)
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function newCfop() {
            $("#modalCfopUpdate #cfop_id").val("");
            $("#modalCfopUpdate #cfop_code").val("");
            $("#modalCfopUpdate #cfop_description").val('');
            $("#modalCfopUpdate #titleUpdateCfop").html("{{ __("fields.cfop_title_register") }}");
            $("#modalCfopUpdate").modal('show');
        }

        $("#modalCfopUpdate #updateForm").validate({
            rules: {
                cfop_code: {
                    required: true,
                    maxlength: 25,
                    uniqueCfopCode: true
                },
                cfop_description: {
                    maxlength: 255
                }
            },
            messages: {
                cfop_code: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                cfop_description: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var id = $("#modalCfopUpdate #cfop_id").val();
                var code = $("#modalCfopUpdate #cfop_code").val();
                var description = $("#modalCfopUpdate #cfop_description").val();


                if (id == null || (id != null && id.length == 0)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/cfop_store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            code: code,
                            description: description,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openCfop(data.data.id)
                            $("#modalCfopUpdate").modal('hide');
                            $("#modalCfop").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/cfop_update') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            id: id,
                            code: code,
                            description: description,
                            enterprise: '{{ Session::get('enterprise')->id }}'
                        },
                        success: function (data) {
                            openCfop(data.data.id)
                            $("#modalCfopUpdate").modal('hide');
                            $("#modalCfop").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                }
            }
        });

        jQuery.validator.addMethod("uniqueCfopCode", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_open_code') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    code: value,
                    enterprise: "{{ Session::get('enterprise')->id }}"
                },
                success: function (data) {
                    var id = $("#cfop_id").val();
                    if (id == null || (id != null && id.length == 0)) {
                        if (data.data == null) {
                            status = true;
                        }
                    } else {
                        if (data.data == null || data.data.id == id) {
                            status = true;
                        }
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        function openTrashCfop(cfop) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('api/cfop_destroy') }}',
                    async: false,
                    data: {id: cfop, enterprise: '{{ Session::get('enterprise')->id }}'},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            if (cfop == $("#cfop_single_product").val()) {
                                $("#cfop_str_single_product").val("")
                                $("#cfop_single_product").val("")
                            }
                            allCfop();
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function openEditCfop(cfop) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: cfop, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalCfopUpdate #cfop_id").val(data.data.id);
                    $("#modalCfopUpdate #cfop_code").val(data.data.code);
                    $("#modalCfopUpdate #cfop_description").val(data.data.description);
                    $("#modalCfopUpdate #titleUpdateCfop").html("{{ __("fields.cfop_title_edit") }} #" + data.data.id);
                    $("#modalCfopUpdate").modal('show');
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function newProduct() {
            $("#modalUpdateProduct #product_single_id").val("");
            $("#modalUpdateProduct #name_single_product").val("");
            $("#modalUpdateProduct #value_single_product").val("");
            $("#modalUpdateProduct #price_single_product").val("");
            $("#modalUpdateProduct #ncm_str_single_product").val("");
            $("#modalUpdateProduct #ncm_single_product").val("");
            $("#modalUpdateProduct #cfop_str_single_product").val("");
            $("#modalUpdateProduct #cfop__single_product").val("");
            $("#modalUpdateProduct #aliquota_single_product").val("");
            $("#modalUpdateProduct #ipi_single_product").val("");
            $("#modalUpdateProduct #unit_single_product").val("");
            $("#modalUpdateProduct #titleUpdateProduct").html("{{ __("fields.product_title_register") }}");
            $("#modalUpdateProduct").modal('show');
        }

        $("#modalUpdateProduct #updateSingleProductForm").validate({
            rules: {
                name_single_product: {
                    required: true,
                    maxlength: 255
                },
                value_single_product: {
                    required: true,
                    validateDigits: true
                },
                price_single_product: {
                    required: true,
                    validateDigits: true
                },
                ncm_str_single_product: {
                    required: true
                },
                cfop_str_single_product: {
                    required: true
                },
                aliquota_single_product: {
                    required: true,
                    validateDigits: true
                },
                ipi_single_product: {
                    required: true,
                    validateDigits: true
                },
                unit_single_product: {
                    required: true,
                    maxlength: 255
                }
            },
            messages: {
                name_single_product: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                value_single_product: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                price_single_product: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                ncm_str_single_product: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                cfop_str_single_product: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                aliquota_single_product: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                ipi_single_product: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                unit_single_product: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var id = $("#modalUpdateProduct #product_single_id").val();
                var name = $("#modalUpdateProduct #name_single_product").val();
                var value = $("#modalUpdateProduct #value_single_product").val();
                var price = $("#modalUpdateProduct #price_single_product").val();
                var ncm = $("#modalUpdateProduct #ncm_single_product").val();
                var cfop = $("#modalUpdateProduct #cfop_single_product").val();
                var aliquota = $("#modalUpdateProduct #aliquota_single_product").val();
                var ipi = $("#modalUpdateProduct #ipi_single_product").val();
                var unit = $("#modalUpdateProduct #unit_single_product").val();
                if (id == null || (id != null && id.length == 0)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/product_store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            name: name,
                            ncm: ncm,
                            cfop: cfop,
                            value: value,
                            price: price,
                            aliquota: aliquota,
                            ipi: ipi,
                            unit: unit,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openProduct(data.data.id)
                            $("#modalUpdateProduct").modal('hide');
                            allProduct();
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/product_update') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            id: id,
                            name: name,
                            ncm: ncm,
                            cfop: cfop,
                            value: value,
                            price: price,
                            aliquota: aliquota,
                            ipi: ipi,
                            unit: unit
                        },
                        success: function (data) {
                            openProduct(data.data.id)
                            $("#modalUpdateProduct").modal('hide');
                            allProduct()
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                }
            }
        });

        var pageProduct = '';
        var searchProduct = '';

        $(document).on('click', '#modalProducts .pagination a', function (e) {
            e.preventDefault();
            pageProduct = $(this).attr('href').split('page=')[1];

            searchProduct = $("#modalProducts #search_text").val();

            allProduct()
        });

        $(document).on('keyup', '#modalProducts #search_text', function (e) {
            pageProduct = '';
            searchProduct = $("#modalProducts #search_text").val();
            allProduct();
        });

        $(document).on('click', '#modalProducts #btnEraser', function (e) {
            pageProduct = '';
            searchProduct = '';

            allProduct();
        });

        function allProduct() {
            if (searchProduct == null || searchProduct.length == 0) {
                $("#modalProducts #search_text").val("");
                $("#modalProducts #btnEraser").hide();
            } else {
                $("#modalProducts #btnEraser").show();
            }

            $.ajax({
                type: "POST",
                url: "{{ url('api/product_all_select') }}?page=" + pageProduct,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    search: searchProduct,
                    select: 'note.product_table',
                    enterprise: '{{ Session::get('enterprise')->id }}'
                },
                success: function (data) {
                    if (data.count == 0 && pageProduct != '' && parseInt(pageProduct) > 1) {
                        pageProduct = parseInt(pageProduct) - 1;
                        allProduct();
                    } else {
                        $("#modalProducts #productTABLE").html(data.html);
                        $("#modalProducts").modal('show')
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function openTrashProduct(product) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('api/product_destroy') }}',
                    async: false,
                    data: {id: product},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            var amountItem = $("#amountItem").val()
                            var html = "";
                            var count = 0;
                            for (var x = 0; x < amountItem; x++) {
                                var idV = $("#id" + x).val();
                                if (idV != product) {

                                    var amount = $("#amount" + x).val();
                                    var name = $("#name" + x).val();
                                    var price = $("#price" + x).val();
                                    var cst = $("#cst" + x).val();
                                    var cst_str = $("#cst_str" + x).val();


                                    html += "<tr>";
                                    html += "<td>";
                                    html += "<input type='hidden' id='id" + count + "' name='id" + count + "' value='" + idV + "'>";
                                    html += "<input type='hidden' id='amount" + count + "' name='amount" + count + "' value='" + amount + "'>";
                                    html += "<input type='hidden' id='name" + count + "' name='name" + count + "' value='" + name + "'>";
                                    html += "<input type='hidden' id='price" + count + "' name='price" + count + "' value='" + price + "'>";
                                    html += "<input type='hidden' id='cst" + count + "' name='cst" + count + "' value='" + cst + "'>";
                                    html += "<input type='hidden' id='cst_str" + count + "' name='cst_str" + count + "' value='" + cst_str + "'>";
                                    html += name;
                                    html += "</td>";
                                    html += "<td>" + amount + "</td>";
                                    html += "<td>{{ __("fields.price_coin") }} " + price + "</td>";
                                    html += "<td>" + cst_str + "</td>";
                                    html += "<td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='removeProduct(" + count + ")'><i class='fa fa-trash'></i></button></td>";
                                    html += "</tr>";
                                    count++;
                                }
                            }
                            $("#amountItem").val(count)
                            $("#bodyItem").html(html);
                            allProduct();
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function openEditProduct(product) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/product_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: product},
                success: function (data) {

                    $("#modalUpdateProduct #product_single_id").val(data.data.id);
                    $("#modalUpdateProduct #name_single_product").val(data.data.name);
                    $("#modalUpdateProduct #value_single_product").val(data.data.value);
                    $("#modalUpdateProduct #price_single_product").val(data.data.price);
                    $("#modalUpdateProduct #ncm_str_single_product").val(data.data.ncm_str);
                    $("#modalUpdateProduct #ncm_single_product").val(data.data.ncm);
                    $("#modalUpdateProduct #cfop_str_single_product").val(data.data.cfop_str);
                    $("#modalUpdateProduct #cfop_single_product").val(data.data.cfop);
                    $("#modalUpdateProduct #aliquota_single_product").val(data.data.aliquota);
                    $("#modalUpdateProduct #ipi_single_product").val(data.data.ipi);
                    $("#modalUpdateProduct #unit_single_product").val(data.data.unit);
                    $("#modalUpdateProduct #titleUpdateProduct").html("{{ __("fields.product_title_edit") }} #" + data.data.id);
                    $("#modalUpdateProduct").modal('show');
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function openProduct(product) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/product_show') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: product},
                success: function (data) {
                    $("#modalAmount #itemModal_str").val(data.data.name)
                    $("#modalAmount #itemModal").val(data.data.id)
                    $("#modalAmount #priceModal_str").val('{{ __("fields.price_coin") }}' + " " + data.data.price)
                    $("#modalAmount #priceModal").val(data.data.price)
                    $("#modalAmount #cst_str").val("")
                    $("#modalAmount #cst").val("")
                    $("#modalAmount #amount").val("")
                    $("#modalAmount").modal('show')
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        var pageCst = '';
        var searchCst = '';

        $(document).on('click', '#modalCst .pagination a', function (e) {
            e.preventDefault();
            pageCst = $(this).attr('href').split('page=')[1];
            searchCst = $("#modalCst #search_text").val();
            allCst();
        });

        $(document).on('keyup', '#modalCst #search_text', function (e) {
            pageCst = '';
            searchCst = $("#modalCst #search_text").val();
            allCst();
        });

        $(document).on('click', '#modalCst #btnEraser', function (e) {
            pageCst = '';
            searchCst = '';
            allCst()
        });

        function allCst() {
            if(searchCst == null || searchCst.length == 0) {
                $("#modalCst #search_text").val("");
                $("#modalCst #btnEraser").hide();
            } else {
                $("#modalCst #btnEraser").show();
            }
            $("#modalCst").modal('show')

            $.ajax({
                type: "POST",
                url: "{{ url('api/cst_all_select') }}?page=" + pageCst,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    search: searchCst,
                    select: 'note.cst_table',
                    enterprise: '{{ Session::get('enterprise')->id }}'
                },
                success: function (data) {
                    if (data.count == 0 && pageCst != '' && parseInt(pageCst) > 1) {
                        pageCst = parseInt(pageCst) - 1;
                        allCst();
                    } else {
                        $("#cstTABLE").html(data.html)
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function newCst() {
            $("#modalCstUpdate #cst_id").val("");
            $("#modalCstUpdate #cst_code").val("");
            $("#modalCstUpdate #cst_description").val('');
            $("#modalCstUpdate #titleUpdateCst").html("{{ __("fields.cst_title_register") }}");
            $("#modalCstUpdate").modal('show');
        }

        $("#modalCstUpdate #updateForm").validate({
            rules: {
                cst_code: {
                    required: true,
                    maxlength: 25,
                    uniqueCstCode: true
                },
                cst_description: {
                    maxlength: 255
                }
            },
            messages: {
                cst_code: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                cst_description: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var id = $("#modalCstUpdate #cst_id").val();
                var code = $("#modalCstUpdate #cst_code").val();
                var description = $("#modalCstUpdate #cst_description").val();

                if (id == null || (id != null && id.length == 0)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/cst_store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            code: code,
                            description: description,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openCst(data.data.id)
                            $("#modalCstUpdate").modal('hide');
                            $("#modalCst").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/cst_update') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            id: id,
                            code: code,
                            description: description,
                            enterprise: '{{ Session::get('enterprise')->id }}'
                        },
                        success: function (data) {
                            openCst(data.data.id)
                            $("#modalCstUpdate").modal('hide');
                            $("#modalCst").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                }
            }
        });

        function openCst(cst) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/cst_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: cst, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalCst").modal('hide')
                    $('#cst_str').val(data.data.code + ((data.data.description != null && data.data.description.length > 0) ? " - " + data.data.description : ""))
                    $('#cst').val(data.data.id)
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        jQuery.validator.addMethod("uniqueCstCode", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/cst_open_code') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    code: value,
                    enterprise: "{{ Session::get('enterprise')->id }}"
                },
                success: function (data) {
                    var id = $("#cst_id").val();
                    if (id == null || (id != null && id.length == 0)) {
                        if (data.data == null) {
                            status = true;
                        }
                    } else {
                        if (data.data == null || data.data.id == id) {
                            status = true;
                        }
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        function openTrashCst(cst) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('api/cst_destroy') }}',
                    async: false,
                    data: {id: cst, enterprise: '{{ Session::get('enterprise')->id }}'},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            if (cst == $("#cst").val()) {
                                $("#cst_str").val("")
                                $("#cst").val("")
                            }
                            allCst();
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function openEditCst(cst) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/cst_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: cst, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalCstUpdate #cst_id").val(data.data.id);
                    $("#modalCstUpdate #cst_code").val(data.data.code);
                    $("#modalCstUpdate #cst_description").val(data.data.description);
                    $("#modalCstUpdate #titleUpdateCst").html("{{ __("fields.cst_title_edit") }} #" + data.data.id);
                    $("#modalCstUpdate").modal('show');
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        $("#modalAmount #registerForm").validate({
            rules: {
                itemModal_str: {
                    required: true
                },
                priceModal: {
                    required: true
                },
                cst_str: {
                    required: true
                },
                amount: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                itemModel_str: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                priceModal: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                cst_str: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                amount: {
                    required: "{{ __("validation_jquery.required") }}",
                    digits: "{{ __("validation_jquery.digits") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var amountItem = $("#amountItem").val()
                var product_str = $("#modalAmount #itemModal_str").val()
                var product = $("#modalAmount #itemModal").val()
                var price = $("#modalAmount #priceModal").val()
                var amount = $("#modalAmount #amount").val()
                var cst = $("#modalAmount #cst").val()
                var cst_str = $("#modalAmount #cst_str").val()
                if ($.isNumeric(amount) && parseInt(amount) >= 0) {
                    price = parseInt(amount) * parseFloat(price);
                    var html = "<tr>";
                    html += "<td>";
                    html += "<input type='hidden' id='id" + amountItem + "' name='id" + amountItem + "' value='" + product + "'>";
                    html += "<input type='hidden' id='amount" + amountItem + "' name='amount" + amountItem + "' value='" + amount + "'>";
                    html += "<input type='hidden' id='name" + amountItem + "' name='name" + amountItem + "' value='" + product_str + "'>";
                    html += "<input type='hidden' id='price" + amountItem + "' name='price" + amountItem + "' value='" + price + "'>";
                    html += "<input type='hidden' id='cst" + amountItem + "' name='cst" + amountItem + "' value='" + cst + "'>";
                    html += "<input type='hidden' id='cst_str" + amountItem + "' name='cst_str" + amountItem + "' value='" + cst_str + "'>";
                    html += product_str;
                    html += "</td>";
                    html += "<td>" + amount + "</td>";
                    html += "<td>{{ __("fields.price_coin") }} " + price + "</td>";
                    html += "<td>" + cst_str + "</td>";
                    html += "<td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='removeProduct(" + amountItem + ")'><i class='fa fa-trash'></i></button></td>";
                    html += "</tr>";
                    $("#bodyItem").append(html);
                    amountItem = parseInt(amountItem) + 1;
                    $("#amountItem").val(amountItem)
                    $("#itemModal_str").val("")
                    $("#itemModal").val("")
                    $("#priceModal_str").val("")
                    $("#priceModal").val("")
                    $("#cst_str").val("")
                    $("#cst").val("")
                    $("#amount").val("")
                    $("#modalAmount").modal('hide')
                    $("#modalProducts").modal('hide')
                }
            }
        });

        function removeProduct(id) {
            var html = "";
            var amountItem = $("#amountItem").val()
            var count = 0;
            for (var x = 0; x < amountItem; x++) {
                if (x != id) {

                    var idV = $("#id" + x).val();
                    var amount = $("#amount" + x).val();
                    var name = $("#name" + x).val();
                    var price = $("#price" + x).val();
                    var cst = $("#cst" + x).val();
                    var cst_str = $("#cst_str" + x).val();


                    html += "<tr>";
                    html += "<td>";
                    html += "<input type='hidden' id='id" + count + "' name='id" + count + "' value='" + idV + "'>";
                    html += "<input type='hidden' id='amount" + count + "' name='amount" + count + "' value='" + amount + "'>";
                    html += "<input type='hidden' id='name" + count + "' name='name" + count + "' value='" + name + "'>";
                    html += "<input type='hidden' id='price" + count + "' name='price" + count + "' value='" + price + "'>";
                    html += "<input type='hidden' id='cst" + count + "' name='cst" + count + "' value='" + cst + "'>";
                    html += "<input type='hidden' id='cst_str" + count + "' name='cst_str" + count + "' value='" + cst_str + "'>";
                    html += name;
                    html += "</td>";
                    html += "<td>" + amount + "</td>";
                    html += "<td>{{ __("fields.price_coin") }} " + price + "</td>";
                    html += "<td>" + cst_str + "</td>";
                    html += "<td align='center'><button class='btn btn-danger btn-sm' type='button' onclick='removeProduct(" + count + ")'><i class='fa fa-trash'></i></button></td>";
                    html += "</tr>";
                    count++;
                }
                $("#amountItem").val(count)
            }
            $("#bodyItem").html(html);
        }

        $("#code_postal_sender").mask("99999-999");

        function getCnpjSender() {
            var cnpj = "";
            var cnpjVar = $("#register_sender").val();
            for (var i = 0; i < cnpjVar.length; i++) {
                if ($.isNumeric(cnpjVar[i])) {
                    cnpj += cnpjVar[i]
                }
            }
            if (cnpj.length == 14) {
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
                        $("#social_name_sender").val(data.tradeName);
                    }
                    if (data.address != null && data.address.number != null && data.address.number.length > 0) {
                        $("#number_sender").val(data.address.number);
                    }
                    if (data.address != null && data.address.postalCode != null && data.address.postalCode.length > 0) {
                        $("#code_postal_sender").val(data.address.postalCode);
                    }
                    if (data.address != null && data.address.street != null && data.address.street.length > 0) {
                        $("#place_sender").val(data.address.streetSuffix + " " + data.address.street);
                    }
                    if (data.address != null && data.address.district != null && data.address.district.length > 0) {
                        $("#district_sender").val(data.address.district);
                    }
                    if (data.address != null && data.address.city != null && data.address.city.name.length > 0) {
                        $("#city_sender").val(data.address.city.name);
                    }
                    if (data.address != null && data.address.city != null && data.address.city.code.length > 0) {
                        $("#code_city_sender").val(data.address.city.code);
                    }
                    if (data.address != null && data.address.state != null && data.address.state.length > 0) {
                        var uf = data.address.state;
                        $("#state_sender").val(data.address.state);
                        $.ajax({
                            url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/",
                            type: "GET",
                            dataType: "JSON",
                        }).done(function (dataUF) {
                            for (var d = 0; d < dataUF.length; d++) {
                                if (dataUF[d].sigla == uf) {
                                    $("#code_state_sender").val(dataUF[d].id)
                                    break;
                                }
                            }
                        });
                    }
                });
            }
        }

        function getCodePostalSender() {
            var code_postal = $("#code_postal_sender").val();
            var uf = '';
            $.ajax({
                url: "http://viacep.com.br/ws/" + code_postal + "/json/",
                type: "GET",
                dataType: "JSON",
                beforeSend: inicializaPreloader()
            }).done(function (data) {
                finalizaPreloader();
                if (data.uf.length > 0) {
                    $("#state_sender").val(data.uf);
                } else {
                    $("#state_sender").val("");
                }
                if (data.localidade.length > 0) {
                    $("#city_sender").val(data.localidade);
                } else {
                    $("#city_sender").val("");
                }
                if (data.bairro.length > 0) {
                    $("#district_sender").val(data.bairro);
                } else {
                    $("#district_sender").val("");
                }
                if (data.logradouro.length > 0) {
                    $("#place_sender").val(data.logradouro);
                } else {
                    $("#place_sender").val("");
                }
                if (data.complemento.length > 0) {
                    $("#complement_sender").val(data.complemento);
                } else {
                    $("#complement_sender").val("");
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

        $("#registerFormGeneral").validate({
            rules: {
                nature_option: {
                    required: true,
                    maxlength: 255
                },
                base_icms: {
                    validateDigits: true
                },
                value_icms: {
                    validateDigits: true
                },
                price_secure: {
                    validateDigits: true
                },
                price_off: {
                    validateDigits: true
                },
                price_accessory: {
                    validateDigits: true
                },
                price_freight: {
                    validateDigits: true
                },
                type_freight: {
                    required: true
                },
                register_freight: {
                    maxlength: 255
                },
                shipping_company: {
                    maxlength: 255
                },
                place_shipping_company: {
                    maxlength: 255
                },
                city_shipping_company: {
                    maxlength: 255
                },
                state_freight: {
                    maxlength: 255
                },
                amount_freight: {
                    digits: true
                },
                specie: {
                    maxlength: 255
                },


                social_name_sender: {
                    required: 255,
                    maxlength: 255
                },
                state_register_sender: {
                    maxlength: 255
                },
                register_sender: {
                    required: true,
                    maxlength: 255
                },
                code_postal_sender: {
                    required: true,
                    maxlength: 255
                },
                place_sender: {
                    required: true,
                    maxlength: 255
                },
                number_sender: {
                    required: true,
                    maxlength: 25
                },
                complement_sender: {
                    maxlength: 255
                },
                district_sender: {
                    required: true,
                    maxlength: 255
                },
                code_city_sender: {
                    required: true,
                    maxlength: 25
                },
                city_sender: {
                    required: true,
                    maxlength: 255
                },
                code_state_sender: {
                    required: true,
                    maxlength: 25
                },
                state_sender: {
                    required: true,
                    maxlength: 255
                },
                state: {
                    maxlength: 255
                }
            },
            messages: {
                nature_option: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                type_freight: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                register_freight: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                shipping_company: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                place_shipping_company: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                city_shipping_company: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                state_registration: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                state_freight: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                amount_freight: {
                    digits: "{{ __("validation_jquery.digits") }}"
                },
                specie: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },

                social_name_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                state_registration_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                register_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_postal_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                place_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                number_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                complement_sender: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                district_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_city_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                city_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                code_state_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                state_sender: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("validateDigits", function (value, element, config) {
            if (value.length > 0) {
                var countPoint = 0, status = true;
                for (var l = 0; l < value.length; l++) {
                    if (!$.isNumeric(value[l]) && value[l] != "." && value[l] != ",") {
                        status = false;
                    } else if (!$.isNumeric(value[l]) && (value[l] == "." || value[l] == ",")) {
                        countPoint++;
                    }
                }
                if (status && countPoint <= 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.digits") }}");
    </script>
@endsection