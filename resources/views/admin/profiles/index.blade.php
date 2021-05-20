@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Work Profiles Table Updated !!',
                        bg_color: '#62f764'
                    });
                    $('#dataListing').html(response.data.appendHtml);
                    $('#profileModal').modal('hide');
                    $('#deleteModal').modal('hide');
                    $('.renderable').hide()
                    if (response.data.count > 0) {
                        $('.renderable').show()
                    }
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
                    <div class="card-header">
                        <div class="row  justify-content-between">
                            <div class="col-lg-2 text-md-left">
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-suitcase"></i> Profile</h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">
                                    <div
                                        class="col-sm-12 col-md-5 col-lg-4 d-flex my-2 my-lg-0  d-md-flex justify-content-end">
                                        <button data-action="{{ route('admin.profiles.bulk', 'delete') }}"
                                            style="display: none;" class="btn btn-sm btn-primary rounded-0 bulk-action-btn"
                                            type="button">
                                            <i class="fa fa-trash"></i>
                                            <span class="d-sm-none d-xl-inline">Delete</span>
                                        </button>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2 renderable" style="display: none;">
                                        <input type="text" data-action="{{ route('admin.profiles.store') }}"
                                            placeholder="search profile" id="search-data" class="form-control" />
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2 col-lg-1">
                                        <button class="btn  btn-sm btn-primary btn-block mt-2 mt-md-0" data-toggle="modal"
                                            data-target="#profileModal">+ Create
                                            New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12" id="dataListing">
                                @include('admin.profiles.listing')
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
                            Delete Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade mt-5" id="profileModal" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Add New Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.profiles.store') }}" method="POST" id="profileForm">
                        @csrf
                        <input type="hidden" name="profile_id" />
                        <div class="form-group">
                            <label>Profile Name</label>
                            <input type="text" required name="profile" placeholder="Name" class="form-control" />
                        </div>
                        <div class="from-group d-flex justify-content-end">
                            <button class="btn btn-primary category-btn"
                                onclick="$('#profileForm').ajaxForm(ResponseHandeling);">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Add Profile
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('backend/js/profiles.js') }}"></script>
@endsection
@endsection
