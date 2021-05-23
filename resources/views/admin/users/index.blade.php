@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Services Table Updated !!',
                        bg_color: '#7abfff'
                    });
                    $('#dataListing').html(response.data.appendHtml);
                    $('#skillModal').modal('hide');
                    $('#deleteModal').modal('hide');
                    $('.renderable').hide()
                    if (response.data.count > 0) {
                        $('.renderable').show()
                    }
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
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-users"></i> Users</h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">

                                    <div class="col-sm-12 col-md-5 col-lg-4 d-flex my-2 my-lg-0  d-md-flex justify-content-end renderable"
                                        style="display: none;">
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
                                    <div class="col-sm-12 col-md-5 col-lg-3 col-lg-2 mt-2 mt-lg-0 renderable"
                                        style="display: none;">
                                        <input type="text" data-action="{{ route('admin.users.store') }}"
                                            placeholder="search users" id="search-data" class="form-control" />
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-2 mt-2 mt-lg-0">
                                        <button class="btn btn-primary btn-block btn-sm " data-toggle="modal"
                                            data-target="#skillModal">+ Create
                                            New</button>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-2 col-xl-1 mt-2 mt-lg-0 renderable"
                                        style="display: none;">
                                        <a href="Javascript:void(0);" class="btn text-lg btn-light border btn-block btn-sm "
                                            id="portfolioSettingsButton">
                                            <i class="fa fa-cog"></i>
                                            <div class="d-inline-block d-md-none ">
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
                                @include('admin.users.listing')
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
    <script>
        $(document).on('click', '.user__delete', function() {
            $('#deleteModal').modal('show');
            $('#deleteModal').find('form').attr('action', $(this).data('action'))
        })

        $(document).on('change', '.active_status_cat', function() {
            const _self = $(this);
            const url = $(this).data('url');
            const is_active = $(this).is(':checked') ? 1 : 0;
            $.post(url, {
                is_active,
                _method: 'PUT'
            }).then(response => {
                _self.next().text(`${is_active == 1 ? 'Active' : 'Inactive'}`);
            })
        })
        $(document).on('click', '.btn__show, .link__show', function(){
            const $modal = $('#projectDetails');
            const $loader = $modal.find('.spinner');
            const url  = $(this).data('action');
            const $frame = $('#project_details');
            $frame.attr('src', url);
            $frame.show();
            $modal.modal('show')
        })
    </script>
@endsection
@endsection
