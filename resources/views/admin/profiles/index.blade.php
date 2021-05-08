@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Work Profiles Table Updated !!',
                        bg_color: '#ce849b'
                    });
                    $('#dataListing').html(response.data.appendHtml);
                    $('#profileModal').modal('hide');
                    $('#deleteModal').modal('hide');
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
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-suitcase"></i> Profile</h6>
                        <div class="d-inline-flex">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#profileModal">+ Create
                                New</button>
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
                        <button class="btn btn-danger category-btn"
                            onclick="$('#deleteForm').ajaxForm(ResponseHandeling);">
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
                            <label>Skill Name</label>
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
    <script>
        const noItemsHTML = `<tr>
                    <td colspan="2">
                        <div class="p-4">
                            No Profiles Found <br>
                            <small class="text-muted">
                                Click &nbsp;
                                    <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#profileModal">
                                        + Create New
                                    </a>
                                &nbsp;
                                button to add new profile.
                            </small>
                        </div>
                    </td>
                </tr>`;
        $(document).ready(function() {
            $('#profileModal').on('hide.bs.modal', function() {
                $(this).find('.modal-header h5').html(modal_titles.add);
                $(this).find(`input[name="category_id"]`).val('')
                $(this).find(`input[name="name"]`).val('')
                $('.category-btn').text('Add Profile')
            })
        })
        $(document).on('click', '.profile__delete', function() {
            $('#deleteModal').modal('show');
            $('#deleteModal').find('form').attr('action', $(this).data('action'))
        })
        $(document).on('click', '.profile__edit', function() {
            const data_text = $(this).parent().parent().prev().text().trim();
            const data_id = $(this).parent().data('id');
            $('#profileModal').find('.modal-header h5').html(modal_titles.update)
            $('#profileModal').find(`input[name="profile_id"]`).val(data_id)
            $('#profileModal').find(`input[name="profile"]`).val(data_text)
            $('#profileModal').modal('show');
            $('.category-btn').text('Update Profile')
        })

    </script>
@endsection
@endsection
