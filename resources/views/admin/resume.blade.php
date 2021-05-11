@extends('layouts.auth-admin')
@section('content')
    <script>
        const responseHandle = {
            rules: {
                content: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                        return editorcontent.length === 0;
                    }
                }
            },
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: 'Saved Successfully.',
                        text: "Your data saved successfully.",
                        bg_color: '#FFFFFF'
                    });
                }
                $('#UserSkillsModal').modal('hide');

            }
        }

    </script>
    <div class="container-fluid">
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">My Resume </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                            <div class="row justify-content-start">
                                <div class="col-lg-6">
                                    <h6><strong><i class="fa fa-book"></i> Education</strong></h6>
                                    <div class="education-wrapper">
                                        <div id="qualifications-container">
                                            @include('admin.qualifications')
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center text-center mt-4">
                                        <button class="btn btn-outline-primary btn-block add-education"
                                            data-id="{{ $resume->id }}" type="button">
                                            <div class="spinner-border spinner-border-sm" role="status"
                                                style="display:none;">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            Add Education +
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h6><strong> <i class="fa fa-suitcase"></i>  Professional Experience</strong> </h6>
                                    <div class="experience-wrapper">
                                        <div id="experiences-container">
                                            @include('admin.experiences')
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center text-center mt-4">
                                        <button class="btn btn-outline-primary btn-block add-experience"
                                            data-id="{{ $resume->id }}" type="button">
                                            <div class="spinner-border spinner-border-sm" role="status"
                                                style="display:none;">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            Add Experience +
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.resume.store') }}" method="POST" id="MyResumeDetails" class="mt-4">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label>Resume Summery</label>
                                        <label>Resume Section Show 
                                            <input type="checkbox" name="show_section" @if($resume->show_section == '1') checked  @endif ></label>
                                    </div>
                                    <textarea name="resume_summery" id="resume_summery" class="form-control">{!! $resume->resume_summery !!}</textarea>
                                </div>
                                <div class="col-lg-12 justify-content-center text-center mt-4">
                                    <button class="btn btn-primary px-5"
                                        onclick="$('#MyResumeDetails').ajaxForm(responseHandle);">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        Save Changes
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        var urls = {
            experience: {
                add: "{{ route('admin.resume.exp.add') }}",
                save: "{{ route('admin.resume.exp.save') }}",
                remove: "{{ route('admin.resume.exp.del') }}",
            },
            qualification: {
                add: "{{ route('admin.resume.qual.add') }}",
                save: "{{ route('admin.resume.qual.save') }}",
                remove: "{{ route('admin.resume.qual.del') }}",
            }
        }

    </script>
    <script src="{{ asset('backend/js/resume.js') }}"></script>
@endsection
@endsection
