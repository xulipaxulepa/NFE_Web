@extends('layouts.app')

@section('title')- @lang("fields.enterprise_title_index") @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i
                                            class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="tblDATES">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        allEnterprises();
        $("#btnEraser").hide();

        var search = '';

        $(document).on('keyup', '#search_text', function (e) {
            search = $("#search_text").val();
            allEnterprises()
        });

        $(document).on('click', '#btnEraser', function (e) {
            search = "";
            allEnterprises();
        });

        function allEnterprises() {
            if (search == null || search.length == 0) {
                $("#search_text").val("");
                $("#btnEraser").hide();
            } else {
                $("#btnEraser").show();
            }

            $.ajax({
                type: "POST",
                url: "{{ url('server/enterprise_all_single_manager') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {search: search, user: '{{ Auth::id() }}'},
                success: function (data) {
                    $("#tblDATES").html(data);
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function destroy(url) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    async: false,
                    data: {'_method': 'DELETE'},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            swal({
                                title: "{{ __("messages.delete") }}",
                                type: "success",
                                confirmButtonText: "{{ __("fields.ok") }}"
                            }).then(function () {
                                allEnterprises()
                            });
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function change(enterprise) {
            swal({
                title: '{{ __("messages.enterprise_access") }}',
                type: 'success',
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.change_yes") }}",
                cancelButtonText: "{{ __("fields.change_not") }}"
            }).then(function () {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('enterprise/list/') }}/' + enterprise,
                    async: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            location.href = '{{ url('home') }}'
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }
    </script>
@endsection