@extends('layouts.auth-admin')
@section('content')
    @php
    $meta = auth()->user()->user_meta;
    if ($meta) {
        $user_meta = json_decode($meta);
        $display_name = $user_meta->display_name ?? auth()->user()->name;
        $bannerImage = $user_meta->background_image ?? null;
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
                        heading: 'Profile Saved.',
                        text: "Your profile saved successfully.",
                        bg_color: '#7abfff'
                    });
                }

            }
        }

    </script>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- Pie Chart -->
            <div class="col-xl-8">
                <form action="{{ route('admin.users.store') }}" method="POST" id="ProfileForm">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
                            <button class="btn btn-primary rounded-quarter d-lg-none"
                                onclick="$('#ProfileForm').ajaxForm(responseHandle)">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                    <span class="sr-only">Loading...</span>
                                </div> Save Profile
                            </button>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body p-0 user-profile-info">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <div class="profile-pictures-wrapper">
                                        <div class="change-cover">
                                            <label class="user-change-cover">
                                                <span><i class="fa fa-camera"></i> Change Cover</span>
                                                <input type="file" data-loader="#banner-loader" class="direct-image-upload"
                                                    data-action="{{ route('admin.my.cover') }}"
                                                    data-image-view="#user__cover" data-cover="true" style="display:none;"
                                                    accept="image/*" value="" />

                                                <input type="hidden" name="">
                                            </label>
                                        </div>
                                        <div id="user__cover" class="user-cover-picture" 
                                            @if (isset($bannerImage)) 
                                                style="background-image:url({{ asset('storage/home-banners/' . $bannerImage) }})" 
                                            @else
                                                style="background-image:url({{ asset('frontend/img/hero-bg.jpg') }})"
                                            @endif>
                                            <div class="d-flex justify-content-center w-100">
                                                @php
                                                    $dp = asset('backend/img/undraw_profile.svg');
                                                    if (filter_var(auth()->user()->display_picture, FILTER_VALIDATE_URL)) {
                                                        $dp = auth()->user()->display_picture;
                                                    } else {
                                                        $dp = asset('storage/home-banners/' . auth()->user()->display_picture);
                                                    }
                                                @endphp
                                                <div
                                                    class="user-profile-picture {{ auth()->user()->is_active == '1' ? 'active' : 'inactive' }}">
                                                    <img id="dp_prev" style="object-fit: contain;background:#fff;"
                                                        src="{{ $dp }}" alt="">

                                                </div>

                                                <label class="upload-dp">
                                                    <span><i class="fa fa-camera text-lg"></i> Change Profile Picture</span>
                                                    <input type="file" data-loader="#banner-loader"
                                                        class="direct-image-upload"
                                                        data-action="{{ route('admin.my.dp') }}"
                                                        data-image-view="#dp_prev" style="display:none;" accept="image/*"
                                                        value="" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 pt-5 px-5">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6 pt-2">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">Name</div>
                                                    <div class="col-sm-12 mb-2">
                                                        <input name="name" required class="form-control" type="text"
                                                            value="{{ $display_name ?? auth()->user()->name }}" />
                                                    </div>

                                                    <div class="col-sm-12">Username</div>
                                                    <div class="col-sm-12 mb-2">
                                                        <input name="username" required class="form-control" type="text"
                                                            value="{{ auth()->user()->username }}" />
                                                    </div>
                                                    <div class="col-sm-12">Email
                                                        <span data-toggle="tooltip" data-placement="top"
                                                            title="This email will shown up to your about section. Your login email will not change."
                                                            class="info email-tooltip">
                                                            <i class="fa fa-info-circle"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-12 mb-2">
                                                        <input name="about_user[email]"
                                                            value="{{ $about->email ?? auth()->user()->email }}"
                                                            type="email" class="form-control" data-tool=".email-tooltip" />
                                                    </div>
                                                    <div class="col-sm-12">Phone</div>
                                                    <div class="col-sm-12 mb-2">
                                                        <input id="phonenumber" data-numeric="true" name="about_user[phone]"
                                                            value="{{ $about->phone ?? '' }}" type="text" maxlength="10"
                                                            minlength="10" class="form-control" />
                                                        <input id="countrycode" data-numeric="true"
                                                            name="about_user[country_code]"
                                                            value="{{ $about->country_code ?? '{"name":"United States","iso2":"us","dialCode":"1","priority":0,"areaCodes":null}' }}"
                                                            type="hidden" class="form-control" />
                                                    </div>
                                                    <div class="col-sm-12">Birtday</div>
                                                    <div class="col-sm-12 mb-2">
                                                        <input required name="about_user[birthday]" min="1960-01-01"
                                                            max="2001-01-01" id="birthday"
                                                            value="{{ $about->birthday ?? '' }}" type="date"
                                                            class="form-control" />
                                                    </div>
                                                    <div class="col-sm-12">Age</div>
                                                    <div class="col-sm-12 mb-2">
                                                        <input readonly name="about_user[age]" required
                                                            value="{{ $about->age ?? '' }}" id="age" min="20" max="40"
                                                            type="number" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-6">

                                            <div class="form-group">
                                                <label> Social Media Profile Links</label>
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <div class="social-box">
                                                            <i class="fab fa-facebook h2 mr-1  text-primary"></i>
                                                            <input type="url" value="{{ $facebook ?? '' }}"
                                                                placeholder="facebook" name="facebook_profile"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label for=""></label>
                                                        <div class="social-box">
                                                            <i class="fab fa-linkedin h2 mr-1 text-primary"></i>
                                                            <input type="url" value="{{ $linkedin ?? '' }}"
                                                                placeholder="linkedin" name="linkedin_profile"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label for=""></label>
                                                        <div class="social-box">
                                                            <i class="fab fa-skype h2 mr-1 text-primary "></i>
                                                            <input type="url" value="{{ $skype ?? '' }}"
                                                                placeholder="skype" name="skype_profile"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label for=""></label>
                                                        <div class="social-box">
                                                            <i class="fab fa-instagram h2 mr-1 text-danger"></i>
                                                            <input type="url" value="{{ $instagram ?? '' }}"
                                                                placeholder="instagram" name="instagram_profile"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label for=""></label>
                                                        <div class="social-box">
                                                            <i class="fab fa-twitter h2 mr-1 text-primary"></i>
                                                            <input type="url" value="{{ $twitter ?? '' }}"
                                                                placeholder="twitter" name="twitter_profile"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center py-4 px-5 px-lg-0">
                                    <button class="btn btn-primary btn-block rounded-quarter"
                                        onclick="$('#ProfileForm').ajaxForm(responseHandle)">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div> Save Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        var initialCountry = "{{ !empty($about->country_code) ? json_decode($about->country_code)->iso2 : 'us' }}";
        $(document).on('change', '#birthday', function() {
            const age = calculateAge(new Date($(this).val()));
            $('#age').val(age);
        })
        $(document).ready(function() {
            $("#phonenumber").intlTelInput({
                initialCountry
            });
        })
        $("#phonenumber").on('countrychange', function(v) {
            const num = $("#phonenumber").intlTelInput("getSelectedCountryData")
            $('#countrycode').val(JSON.stringify(num))
        })

    </script>
@endsection
@endsection
