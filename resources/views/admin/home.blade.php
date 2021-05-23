@extends('layouts.auth-admin')
@section('content')
    @php
    $meta = auth()->user()->user_meta;
    if ($meta) {
        $user_meta = json_decode($meta);
        $display_name = $user_meta->display_name ?? auth()->user()->name;
        $bannerImage =  $user_meta->background_image ?? null;
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
                        bg_color: '#7abfff'
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
                        <h6 class="m-0 font-weight-bold text-primary">Home Management</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.home.store') }}" method="POST" id="homeMangementForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Display Name</label>
                                        <input name="display_name" required class="form-control" type="text"
                                            value="{{ $display_name ?? auth()->user()->name }}" />
                                        <small class="d-block mt-1">The bigger name heading. By default we're using your
                                            account name.</small>
                                    </div>
                                    <div class="form-group">
                                        <label> Social Media Profile Links</label>
                                        <div class="social-box">
                                            <i class="fab fa-facebook h2 mr-1  text-primary"></i>
                                            <input type="url" value="{{ $facebook ?? '' }}" placeholder="facebook"
                                                name="facebook_profile" class="form-control" />
                                        </div>
                                        <div class="social-box">
                                            <i class="fab fa-linkedin h2 mr-1 text-primary"></i>
                                            <input type="url" value="{{ $linkedin ?? '' }}" placeholder="linkedin"
                                                name="linkedin_profile" class="form-control" />
                                        </div>

                                        <div class="social-box">
                                            <i class="fab fa-skype h2 mr-1 text-primary "></i>
                                            <input type="url" value="{{ $skype ?? '' }}" placeholder="skype"
                                                name="skype_profile" class="form-control" />
                                        </div>

                                        <div class="social-box">
                                            <i class="fab fa-instagram h2 mr-1 text-danger"></i>
                                            <input type="url" value="{{ $instagram ?? '' }}" placeholder="instagram"
                                                name="instagram_profile" class="form-control" />
                                        </div>

                                        <div class="social-box">
                                            <i class="fab fa-twitter h2 mr-1 text-primary"></i>
                                            <input type="url" value="{{ $twitter ?? '' }}" placeholder="twitter"
                                                name="twitter_profile" class="form-control" />
                                        </div>

                                    </div>
                                    
                                </div>
                                <div class="col-md-7">
                                    
                                    <div class="form-group">
                                        <label>Background Banner</label>
                                        <label class="dropzone w-100 @if (isset($bannerImage)) has-file @endif">
                                            <div class="dz-preview ">
                                                <img id="background__image__preview_img" @if (isset($bannerImage)) src="{{ asset('storage/home-banners/' .  $bannerImage) }}" @endif
                                                    style="{{ ( !isset($bannerImage) ) ? 'display: none;' : '' }}" />
                                            </div>
                                            @if (!isset($bannerImage))
                                                <div class="dropzone-message lg">
                                                    Click Or Drop Your file Here
                                                </div>
                                            @endif
                                            <input 
                                                type="file" 
                                                data-loader="#banner-loader"
                                                class="direct-image-upload "
                                                data-action="{{ route('admin.home.banner') }}"
                                                data-image-view="#background__image__preview_img" 
                                                style="display:none;"
                                                accept="image/*"
                                                value="" 
                                            />
                                        </label>

                                    </div>
                                    
                                </div>
                                
                                <div class="col-sm-12 justify-content-center text-center">

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
@endsection
