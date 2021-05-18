@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: "Portfolio Settings Changed.",
                        bg_color: '#62f764'
                    });
                }
            }
        }

        const modal_titles = {
            add: 'Add New Profile',
            update: 'Update Profile'
        }

    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header">
                        <div class="row  justify-content-between">
                            <div class="col-lg-2 text-md-left">
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-book"></i> Portfolios</h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2">
                                        <select id="CategoriesFilter" data-action="{{ route('admin.portfolios.store') }}"
                                            class="form-control">
                                            <option value="">All Categories</option>
                                            @foreach ($portfolio_categories as $pcat)
                                                <option value="{{ $pcat->id }}">
                                                    {{ $pcat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2">
                                        <input type="text" data-action="{{ route('admin.portfolios.store') }}"
                                            placeholder="search portfolio name" id="search-data"
                                            class="form-control my-2 my-md-0" />

                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2 col-lg-1">
                                        <a href="{{ route('admin.portfolios.create') }}"
                                            class="btn btn-primary btn-block btn-sm py-2">+ Create
                                            New
                                        </a>
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
                                @include('admin.portfolios.listing')
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
                            Delete Portfolio
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Settings Modal-->
    <div class="modal fade" id="portfolioSettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-cogs"></i> Portfolio Basic Settings</h6>
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
                            <form action="{{ route('admin.portfolio.settings') }}" method="POST" id="portfolioSettingsForm">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-end">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="hide_portfolio"
                                                        class="custom-control-input active_status_portfolio" id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">Hide Portfolio
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
    <!-- Portfolio Settings Modal-->
    <div class="modal fade" id="projectDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h6 class="modal-title" id="exampleModalLabel"></h6>
                    <button class="close" style="font-size: 36px;" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <iframe src="" style="height: 60vh;" width="100%" frameborder="0" id="project_details"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('backend/js/portfolio.js') }}"></script>
@endsection
@endsection
