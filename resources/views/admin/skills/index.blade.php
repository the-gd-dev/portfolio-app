@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Profile\'s Skills Table Updated !!',
                        bg_color: '#ce849b'
                    });
                    $('#dataListing').html(response.data.appendHtml);
                    $('#skillModal').modal('hide');
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
                    <div class="card-header">
                        <div class="row  justify-content-between">
                            <div class="col-lg-2 text-md-left">
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-angle-double-right"></i> Skills</h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2">
                                        <select id="ProfileFilter" data-action="{{ route('admin.skills.store') }}"
                                            class="form-control">
                                            <option value="">All Profiles</option>
                                            @foreach ($profiles as $profile)
                                                <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2 my-2 my-md-0">
                                        <input type="text" data-action="{{ route('admin.skills.store') }}"
                                            placeholder="search skill" id="search-data"
                                            class="form-control" />


                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2 col-lg-1">

                                        <button class="btn btn-primary  btn-block" data-toggle="modal"
                                            data-target="#skillModal">+ Create
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
                                @include('admin.skills.listing')
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
                            Delete Skill
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
                    <h5 class="modal-title" id="skillModalLabel">Add New Skill</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.skills.store') }}" method="POST" id="skillForm">
                        @csrf
                        <input type="hidden" name="skill_id" />
                        <div class="form-group">
                            <label>Profile</label>
                            <select name="profile_id" id="" class="form-control">
                                @foreach ($profiles as $profile)
                                    <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Skill</label>
                            <input type="text" required name="skill" placeholder="Name" class="form-control" />
                        </div>

                        <div class="from-group d-flex justify-content-end">
                            <button class="btn btn-primary category-btn"
                                onclick="$('#skillForm').ajaxForm(ResponseHandeling);">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Add Skill
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
@section('scripts')
    <script>
        var chooseIconUrl = "{{ route('admin.skills.icons') }}";
        var iconFetchUrl = "{{ route('icons.index') }}";
        var iconColors = "{{ route('admin.skills.colors') }}";
        var skillsStore = "{{ route('admin.skills.store') }}";

    </script>
    <script src="{{ asset('backend/js/skills.js') }}"></script>
@endsection
@endsection
