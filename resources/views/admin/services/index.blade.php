@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Services Table Updated !!',
                        bg_color: '#62f764'
                    });
                    $('#dataListing').html(response.data.appendHtml);
                    $('#skillModal').modal('hide');
                    $('#deleteModal').modal('hide');
                }
            }
        }

        const modal_titles = {
            add: 'Add New Service',
            update: 'Update Service'
        }

    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <div class="row  justify-content-between">
                            <div class="col-lg-2 text-md-left">
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-server"></i> Services</h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2">
                                        <input type="text" data-action="{{ route('admin.services.store') }}"
                                            placeholder="search skill" id="search-data" class="form-control" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2 col-lg-1">
                                        <button class="btn btn-primary btn-block mt-2 mt-md-0" data-toggle="modal"
                                            data-target="#skillModal">+ Create
                                            New</button>
                                    </div>
                                    <div class="col-lg-1">
                                        <a href="Javascript:void(0);"
                                            class="btn text-lg btn-light border btn-block btn-sm mt-2 mt-md-0"
                                            id="portfolioSettingsButton">
                                            <i class="fa fa-cog"></i>
                                            <div class="d-inline-block d-lg-none ">
                                                Settings
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12" id="dataListing">
                                @include('admin.services.listing')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this. <br>
                    <strong class="text-danger"> This action is irreversible.</strong>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger category-btn" onclick="$('#deleteForm').ajaxForm(ResponseHandeling);">
                            <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Delete Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade mt-5" id="skillModal" role="dialog" aria-labelledby="skillModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="skillModalLabel">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.services.store') }}" method="POST" id="skillForm">
                        @csrf
                        <input type="hidden" name="service_id" />
                        <div class="form-group">
                            <label>Service Name</label>
                            <input type="text" name="service" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="service_description" class="form-control" id="service_description"></textarea>
                        </div>

                        <div class="from-group d-flex justify-content-end">
                            <button class="btn btn-primary category-btn"
                                onclick="$('#skillForm').ajaxForm(ResponseHandeling);">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Add Service
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="IconsModal" tabindex="-1" role="dialog" aria-labelledby="IconsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <div class="w-75">
                        <input type="text" placeholder="search icon ..." class="form-control" id="search_icon" />
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="row justify-content-center border-top">
                        <div class="col-sm-2">
                            <div class="spinner-border spinner-border-xl icons-loader" role="status" style="display: none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row" id="icons-wrapper" data-id="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service Settings Modal-->
    <div class="modal fade" id="portfolioSettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-cogs"></i> Service Basic Settings</h6>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center" id="data-loader">
                            <div class="spinner-border spinner-border-xl" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span class="h5 d-block mt-4 text-dark">
                                loading settings please wait ...</span>
                        </div>
                        <div class="col-sm-12 px-4">
                            <form action="{{ route('admin.services.settings') }}" method="POST"
                                id="portfolioSettingsForm">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-end">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="hide_service"
                                                        class="custom-control-input active_status_portfolio"
                                                        id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">Hide Service
                                                        Section </label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label>Change Header Title
                                                    <span data-toggle="tooltip"
                                                        title="Change the main heading text from 'PORTFOLIO'. ">
                                                        <i class="fa fa-info-circle"></i></span>
                                                </label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="header_title[apply]" value="1" />
                                                </label>
                                            </div>
                                            <input type="text" class="form-control" name="header_title[value]">
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label>Number Of Frontend Portfolios
                                                    <span data-toggle="tooltip"
                                                        title="Number of portfolios shown to the user viewing your portfolio.">
                                                        <i class="fa fa-info-circle"></i></span>
                                                </label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="max_portfolios[apply]" value="1" />
                                                </label>
                                            </div>
                                            <input type="number" name="max_portfolios[value]" value="9" min="1"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label>Description</label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="description[apply]" value="1" />
                                                </label>
                                            </div>
                                            <textarea name="description[value]" class="form-control" id=""></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-light border category-btn btn-block"
                                        onclick="$('#portfolioSettingsForm').ajaxForm(ResponseHandeling);">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        Save Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@section('scripts')
    <script>
        var chooseIconUrl = "{{ route('admin.services.icons') }}";
        var iconFetchUrl = "{{ route('icons.index') }}";
        var iconColors = "{{ route('admin.services.colors') }}";
        var servicesStore = "{{ route('admin.services.store') }}";

    </script>
    <script src="{{ asset('backend/js/services.js') }}"></script>
@endsection
@endsection
