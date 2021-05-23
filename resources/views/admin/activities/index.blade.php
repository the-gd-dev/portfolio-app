@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Portfolio Category Data Updated !!',
                        bg_color: '#86ff88'
                    });
                    if(response.data){
                        $('#dataListing').html(response.data.appendHtml);
                        $('#profileModal').modal('hide');
                        $('#deleteModal').modal('hide');
                        $('.renderable').hide()
                        if(response.data.count > 0){
                            $('.renderable').show()
                        }
                    }
                }
            }
        }

        const modal_titles = {
            add: 'Add New  Category',
            update: 'Update  Category'
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
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-book"></i> Portfolio Category
                                </h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">
                                    <div
                                        class="col-sm-12 col-md-5 col-lg-3 d-flex my-2 my-lg-0  d-md-flex justify-content-end renderable" style="display: none;">
                                        <button data-action="{{ route('admin.portfolio-categories.bulk', 'delete') }}"
                                            style="display: none;" class="btn btn-sm btn-primary rounded-0 bulk-action-btn"
                                            type="button">
                                            <i class="fa fa-trash"></i>
                                            <span class="d-sm-none d-xl-inline">Delete</span>
                                        </button>
                                        <button 
                                            data-action="{{ route('admin.portfolio-categories.bulk', 'active') }}"
                                            style="display: none;"
                                            class="btn mx-2 btn-sm btn-success rounded-0 bulk-action-btn" type="button">
                                            <span>Active</span>
                                        </button>
                                        <button data-action="{{ route('admin.portfolio-categories.bulk', 'inactive') }}"
                                            style="display: none;"
                                            class="btn btn-sm btn-light border rounded-0 bulk-action-btn" type="button">
                                            <span>Inactive</span>
                                        </button>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2  renderable" style="display: none;">
                                        <input type="text" data-action="{{ route('admin.portfolio-categories.store') }}"
                                            placeholder="search portfolio category" id="search-data"
                                            class="form-control my-2 my-lg-0" />

                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2 col-lg-1">
                                        <button class="btn btn-primary btn-block btn-sm" data-toggle="modal"
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
                                @include('admin.portfolio-categories.listing')
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
                            Delete Category
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
                    <h5 class="modal-title" id="profileModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.portfolio-categories.store') }}" method="POST" id="profileForm">
                        @csrf
                        <input type="hidden" name="category_id" />
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" required name="name" placeholder="Name" class="form-control" />
                        </div>
                        <div class="from-group d-flex justify-content-end">
                            <button class="btn btn-primary category-btn"
                                onclick="$('#profileForm').ajaxForm(ResponseHandeling);">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Add Category
                            </button>
                            <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('backend/js/portfolio.js') }}"></script>
@endsection
@endsection
