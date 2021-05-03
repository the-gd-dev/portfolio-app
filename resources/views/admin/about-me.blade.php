@extends('layouts.auth-admin')
@section('content')
    @php
    $meta = auth()->user()->user_meta;
    if ($meta) {
        $user_meta = json_decode($meta);
        $display_name = $user_meta->display_name;

        $skills = implode(',', $user_meta->skills);
        $facebook = $user_meta->social_profiles->facebook ?? '';
        $instagram = $user_meta->social_profiles->instagram ?? '';
        $skype = $user_meta->social_profiles->skype ?? '';
        $linkedin = $user_meta->social_profiles->linkedin ?? '';
        $twitter = $user_meta->social_profiles->twitter ?? '';
    }
    @endphp
    <script>
        const responseHandle = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: 'Saved Successfully.',
                        text: "Your data saved successfully.",
                        bg_color: '#FFFFFF'
                    });
                }

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
                        <h6 class="m-0 font-weight-bold text-primary">About Me </h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.about.store') }}" method="POST" id="homeMangementForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-3">
                                    <div class="img-preview">
                                        <div class="form-group">
                                            <label>Professional Image</label>
                                            <label class="dropzone w-75">
                                                <div class="dz-preview" style="display: none;">
                                                    <img id="background__image__preview_img" />
                                                </div>
                                                <div class="dropzone-message lg">
                                                    Click Or Drop Your file Here
                                                </div>

                                            </label>
                                            <input type="file" data-loader="#banner-loader" name="about_image"
                                                class="simple-image-upload"
                                                data-image-view="#background__image__preview_img" style="display:none;"
                                                accept="image/*" required />
                                        </div>
                                    </div>
                                    <small>
                                        Your image should look <b>professional</b> . <br>
                                        Please don't use <b>blurry</b> images. <br>
                                        Preferred size <b>300 X 350 (in pixels)</b>
                                    </small>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>About Summery</label>
                                        <textarea name="display_name" class="form-control" type="text" value=""></textarea>

                                    </div>
                                    <div class="form-group">
                                        <label>Skills</label>
                                        <input name="skills" value="" required type="text" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Details</label>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-2 mt-2">Birthday</div>
                                            <div class="col-sm-12 col-lg-4"><input required name="birthday" min="1960-01-01"
                                                    max="2001-01-01" id="birthday" value="" type="date"
                                                    class="form-control" /></div>
                                            <div class="col-sm-12 col-lg-2 text-lg-right mt-2">Age</div>
                                            <div class="col-sm-12 col-lg-4">
                                                <input name="age" required value="" id="age" min="22" max="40" type="number"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-sm-12 col-lg-2 mt-2">Website</div>
                                            <div class="col-sm-12 col-lg-4"><input required name="website" value="" type="url"
                                                    class="form-control" /></div>
                                            <div class="col-sm-12 col-lg-2 text-lg-right mt-2">Degree</div>
                                            <div class="col-sm-12 col-lg-4">
                                                <input name="degree" required value="" id="degree" min="22" max="40"
                                                    type="number" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-12 col-lg-2 mt-2">Phone</div>
                                            <div class="col-sm-12 col-lg-4"><input name="phone" value="" type="text"
                                                    class="form-control" /></div>
                                            <div class="col-sm-12 col-lg-2 text-lg-right mt-2">Email</div>
                                            <div class="col-sm-12 col-lg-4">
                                                <input name="email" value="" min="22" max="40" type="email"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-2 mt-2">City</div>
                                            <div class="col-sm-12 col-lg-4"><input required name="birthday" value="" type="date"
                                                    class="form-control" /></div>
                                            <div class="col-sm-12 col-lg-2 text-lg-right mt-2">Freelance</div>
                                            <div class="col-sm-12 col-lg-4">
                                                <select name="freelancer" class="form-control">
                                                    <option value="1"> Available </option>
                                                    <option value="0"> Not Available </option>
                                                    <option value="2"> Sometimes </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 justify-content-center text-center">

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
@section('scripts')
    <script>
        $(document).on('change', '#birthday', function() {

        })
        $(document).on('change', '#birthday', function() {
            const age = calculateAge(new Date($(this).val()));
            $('#age').val(age);
        })

    </script>

@endsection
@endsection
