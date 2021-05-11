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
        @if (!isset($about->about_image))
            responseHandle.customErrorShow = function() {
            const input_val = $('input[type="file"]').val();
            $('.dropzone').addClass('dropzone-remove');
            $('label.is-invalid-file').remove();
            if (input_val === '') {
            $('.dropzone').after('<label class="is-invalid-file">Please choose a picture.</label>');
            $('.dropzone').addClass('dropzone-remove');
            }
            $('#homeMangementForm').find('button .spinner-border').hide();
            }
        @endif

    </script>
    <div class="container-fluid">
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">About Me </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.about.store') }}" method="POST" id="homeMangementForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-4">
                                    <div class="img-preview">
                                        <div class="form-group">
                                            <label>Professional Image</label>
                                            <label class="dropzone w-50">
                                                <div class="dz-preview">
                                                    <img id="background__image__preview_img" @if (isset($about->about_image) && $about->about_image !== 'none') src="{{ asset('storage/about-images/' . $about->about_image) }}" @endif
                                                        style="{{ !isset($about->about_image) || $about->about_image == 'none' ? 'display: none;' : '' }}" />
                                                </div>
                                                @if (!isset($about->about_image) || $about->about_image == 'none')
                                                    <div class="dropzone-message lg">
                                                        Click Or Drop Your file Here
                                                    </div>
                                                @endif
                                                <input type="file" data-loader="#banner-loader" name="about_image"
                                                    class="direct-image-upload  {{ !isset($about->about_image) ? 'validate-hidden' : '' }}  "
                                                    data-action="{{ route('admin.about.image') }}"
                                                    data-image-view="#background__image__preview_img" style="display:none;"
                                                    accept="image/*" {{ !isset($about->about_image) ? 'required' : '' }}
                                                    value="" />
                                            </label>

                                        </div>
                                        <small class="text-muted">
                                            Your image should look <b>professional</b> .
                                            Please don't use <b>blurry</b> images.
                                            Preferred size <b>300 X 350 (in pixels)</b>
                                        </small>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label>Details
                                            <span data-toggle="tooltip" data-placement="right"
                                                title="You can leave details which you don't want to show." class="info">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        </label>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-3 mt-2">Birthday</div>
                                            <div class="col-sm-12 col-lg-9 mb-2 mb-2">
                                                <input required name="birthday" min="1960-01-01" max="2001-01-01"
                                                    id="birthday" value="{{ $about->birthday ?? '' }}" type="date"
                                                    class="form-control" />
                                            </div>
                                            <div class="col-sm-12 col-lg-3 mt-2">Age</div>
                                            <div class="col-sm-12 col-lg-9 mb-2">
                                                <input name="age" required value="{{ $about->age ?? '' }}" id="age"
                                                    min="20" max="40" type="number" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-sm-12 col-lg-3 mt-2">Website</div>
                                            <div class="col-sm-12 col-lg-9 mb-2"><input name="website"
                                                    value="{{ $about->website ?? '' }}" type="url" class="form-control" />
                                            </div>
                                            <div class="col-sm-12 col-lg-3 mt-2">Degree</div>
                                            <div class="col-sm-12 col-lg-9 mb-2">
                                                <select name="degree" class="form-control">
                                                    <option value="">Choose...</option>
                                                    <option @if (isset($about) && $about->degree === 'phd') selected @endif value="phd">Phd</option>
                                                    <option @if (isset($about) && $about->degree === 'masters') selected @endif value="masters">Masters
                                                    </option>
                                                    <option @if (isset($about) && $about->degree === 'graduate') selected @endif value="graduate">Graduate
                                                    </option>
                                                    <option @if (isset($about) && $about->degree === 'diploma') selected @endif value="diploma">Diploma
                                                    </option>
                                                    <option @if (isset($about) && $about->degree === 'matric') selected @endif value="matric">Matric
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-3 mt-2">Phone</div>
                                            <div class="col-sm-12 col-lg-9 mb-2">
                                                <input id="phonenumber" data-numeric="true" name="phone"
                                                    value="{{ $about->phone ?? '' }}" type="text" maxlength="10"
                                                    minlength="10" class="form-control" />
                                                <input id="countrycode" data-numeric="true" name="country_code"
                                                    value="{{ $about->country_code ?? '{"name":"United States","iso2":"us","dialCode":"1","priority":0,"areaCodes":null}' }}"
                                                    type="hidden" class="form-control" />
                                            </div>
                                            <div class="col-sm-12 col-lg-3 mt-2">Email</div>
                                            <div class="col-sm-12 col-lg-9 mb-2">
                                                <input name="email" value="{{ $about->email ?? '' }}" type="email"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-3 mt-2">City</div>
                                            <div class="col-sm-12 col-lg-9 mb-2"><input name="city"
                                                    value="{{ $about->city ?? '' }}" type="text" class="form-control" />
                                            </div>
                                            <div class="col-sm-12 col-lg-3 mt-2">Freelance</div>
                                            <div class="col-sm-12 col-lg-9 mb-2">
                                                <select name="freelancer" class="form-control">
                                                    <option value="">Choose...</option>
                                                    <option @if (isset($about) && $about->freelancer === '1') selected @endif value="1"> Available
                                                    </option>
                                                    <option @if (isset($about) && $about->freelancer === '0') selected @endif value="0"> Not Available
                                                    </option>
                                                    <option @if (isset($about) && $about->freelancer === '2') selected @endif value="2"> Sometimes
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label class="w-100">
                                            About Summery
                                            <span data-toggle="tooltip" data-placement="right"
                                                title="Brief summery of yourself." class="info">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        </label>
                                        <textarea name="about_summery" id="about_summery" maxlength="1000" rows="5"
                                            class="form-control" type="text">{!! $about->about_summery ?? '' !!}</textarea>

                                    </div>
                                    <div class="form-group">
                                        <label>Work Profiles</label>
                                        <select name="work_profiles[]" required id="work_profiles" multiple="multiple"
                                            class="form-control">
                                            @foreach ($profiles as $profile)
                                                <option value="{{ $profile->id }}">{{ $profile->profile }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="w-100">
                                            Work Profiles Summery
                                            <span data-toggle="tooltip" data-placement="right"
                                                title="Brief summery of your work profiles." class="info">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        </label>
                                        <textarea name="work_profiles_summery" id="skills_summery" maxlength="1000" rows="5"
                                            class="form-control" type="text">{!! $about->work_profiles_summery ?? '' !!}</textarea>

                                    </div>
                                    <div class="form-group ">
                                        <div class="row justify-content-between">
                                            <div class="col-sm-3"><label class="mt-2">Skills </label></div>
                                            <div class="col-sm-6 text-md-right">
                                                <button type="button" data-toggle="modal" data-target="#UserSkillsModal"
                                                    class="btn btn-primary btn-sm mb-2">Add details to skills</button>
                                            </div>
                                        </div>
                                        <ul id="skills-names" class="list-unstyled" data-toggle="modal"
                                            data-target="#UserSkillsModal"></ul>
                                    </div>

                                    <label class="w-100">
                                        Skills Summery
                                        <span data-toggle="tooltip" data-placement="right"
                                            title="Brief summery of yourself." class="info">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </label>
                                    <textarea name="skills_summery" id="skills_summery" maxlength="1000" rows="3"
                                        class="form-control" type="text">{!! $about->skills_summery ?? '' !!}</textarea>

                                </div>
                                <div class="col-lg-12 justify-content-center text-center mt-4">
                                    <button class="btn btn-primary px-5"
                                        onclick="$('#homeMangementForm').ajaxForm(responseHandle);">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.user-skills')
@section('scripts')
    <script>
        var initialCountry = "{{ !empty($about->country_code) ? json_decode($about->country_code)->iso2 : 'us' }}";
        var skillsChange = "{{ route('admin.users.skills') }}";
        var profileSkills = "{{ route('admin.profiles.skills') }}";
        var workProfiles = {!! $about->work_profiles ?? '[]' !!};
        var skillOrderChange = "{{ route('admin.user-skills.order') }}";

    </script>
    <script src="{{ asset('backend/js/about.me.js') }}"></script>
@endsection
@endsection
