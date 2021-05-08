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
                                <div class="col-lg-3">
                                    <div class="img-preview">
                                        <div class="form-group">
                                            <label>Professional Image</label>
                                            <label class="dropzone w-75">
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
                                            <div class="col-sm-3 text-md-right">
                                                <button type="button" data-toggle="modal" data-target="#UserSkillsModal"
                                                    class="btn btn-primary btn-sm mb-2">Add details to skills</button>
                                            </div>
                                        </div>
                                        <ul id="skills-names" class="list-unstyled"  data-toggle="modal" data-target="#UserSkillsModal"></ul>
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
        $(document).on('change', '#birthday', function() {
            const age = calculateAge(new Date($(this).val()));
            $('#age').val(age);
        })
        $(document).ready(function() {
            $("#phonenumber").intlTelInput({
                initialCountry: "{{ !empty($about->country_code) ? json_decode($about->country_code)->iso2 : 'us' }}"
            });
        })
        $("#phonenumber").on('countrychange', function(v) {
            const num = $("#phonenumber").intlTelInput("getSelectedCountryData")
            $('#countrycode').val(JSON.stringify(num))
        })
        $('#skills')
            .select2()
            .on('change', async function(e) {
                const skills = $(this).val();
                var loader2 = $('.skills-loader-2')
                const response = await $.get("{{ route('admin.users.skills') }}", {
                    skills
                });
                $('#skills-names').html('');
                $('#skills-table').html('');
                $('.skills-list').hide();
                if (response.hasOwnProperty('skills')) {
                    if (response.skills.length > 0) {
                        loader2.show();
                        response.skills.map((skill, key) => {
                            const skill_name  = skill.skill.skill;
                            const skill_id  = skill.skill.id;
                            skill_append(skill.skill);
                            // $('#skills-names').append(`<li>${skill_name}</li>`)
                            const v = parseInt(skill.skill_accuracy || 0);
                            const calLeft = v > 0 ? (v * 2.6) - v : 0;
                            const row = `<tr data-id="${skill_id}">
                                            <td>
                                                <span class="re-order-icon skills-reorder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                                        <path d="M15.5 17C16.3284 17 17 17.6716 17 18.5C17 19.3284 16.3284 20 15.5 20C14.6716 20 14 19.3284 14 18.5C14 17.6716 14.6716 17 15.5 17ZM8.5 17C9.32843 17 10 17.6716 10 18.5C10 19.3284 9.32843 20 8.5 20C7.67157 20 7 19.3284 7 18.5C7 17.6716 7.67157 17 8.5 17ZM15.5 10C16.3284 10 17 10.6716 17 11.5C17 12.3284 16.3284 13 15.5 13C14.6716 13 14 12.3284 14 11.5C14 10.6716 14.6716 10 15.5 10ZM8.5 10C9.32843 10 10 10.6716 10 11.5C10 12.3284 9.32843 13 8.5 13C7.67157 13 7 12.3284 7 11.5C7 10.6716 7.67157 10 8.5 10ZM15.5 3C16.3284 3 17 3.67157 17 4.5C17 5.32843 16.3284 6 15.5 6C14.6716 6 14 5.32843 14 4.5C14 3.67157 14.6716 3 15.5 3ZM8.5 3C9.32843 3 10 3.67157 10 4.5C10 5.32843 9.32843 6 8.5 6C7.67157 6 7 5.32843 7 4.5C7 3.67157 7.67157 3 8.5 3Z" fill="#212121"/>
                                                    </svg>    
                                                </span>
                                            </td>
                                            <td>
                                                <input type="hidden" name="skills[${key}][skill_id]" value="${skill_id}" />
                                                <input type="text" readonly value="${skill_name}" class="form-control h-25" />
                                            </td>
                                            <td>
                                                <div class="range-wrap">
                                                    <input 
                                                        min="0" 
                                                        max="100" 
                                                        type="range" 
                                                        value="${skill.skill_accuracy || 0}" 
                                                        name="skills[${key}][skill_accuracy]"  
                                                        class="form-control range" 
                                                    />
                                                    <output class="bubble" style="display:none;left: ${calLeft.toFixed(2)}px"> ${skill.skill_accuracy || 0 }</output>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea  name="skills[${key}][skill_summery]" class="form-control h-25" rows="1">${skill.skill_summery || ''}</textarea>
                                            </td>
                                        </tr>`;
                            $('#skills-table').append(row);
                        })
                        loader2.hide();
                        setDifferentLiColors();
                        $('.skills-list').show();
                    }
                }
            });
        $('#work_profiles')
            .select2()
            .on('change', async function(e) {
                var loader1 = $('.skills-loader-1')
                const profiles = $(this).val();

                const response = await $.post("{{ route('admin.profiles.skills') }}", {
                    profiles,
                    skills: $('#skills').val()
                });
                $('#skills').html('').hide();
                if (response.hasOwnProperty('profiles') && response.profiles.length) {
                    var data = [];
                    loader1.show();
                    response.profiles.map(profile => {
                        data.push({
                            id: profile.id,
                            text: profile.profile,
                            children: []
                        })
                        if (profile.skills.length > 0) {
                            var skills = [];
                           
                            response.user_skills.map(sk => skills.push(parseInt(sk)))
                            profile.skills.map(skill => {
                                // skill_append(skill)
                                data[(data.length - 1)].children.push({
                                    id: skill.id,
                                    text: skill.skill,
                                    selected: skills.includes(skill.id)
                                })
                            })
                        } else {
                            data[(data.length - 1)].children.push({
                                id: 0,
                                text: 'No skills found.',
                                disabled: true,
                            })
                        }

                    })
                    $('#skills').select2({
                            data
                        }).trigger('change')
                    setDifferentLiColors()
                    loader1.hide();
                    $('#skills').show();
                }
            });
        function skill_append(skill){
            const appendHtml = `<li>
                ${skill.icon && skill.icon != '' ? `<i class="${skill.icon}"></i>` : '' }
                ${skill.skill}
            </li>`;
            $('#skills-names').append(appendHtml)
        }
        function setDifferentLiColors(){
            $('#skills-names li').each(function(k, li) {
                $(li).css('background', `rgb(13 ${10 * k} 185)`);
            })
        }
        $(document).on('input', '.range', function() {
            const bubble = $(this).next();
            const v = parseInt($(this).val());
            const calLeft = v > 0 ? (v * 2.6) - v : 0;
            bubble.css('left', calLeft.toFixed(2) + 'px')
            bubble.text(v);
        })
        $('#work_profiles').val({!! $about->work_profiles !!}).trigger('change')
        CKEDITOR.replace('about_summery', {
            height: '120',
        });
        CKEDITOR.replace('skills_summery', {
            height: '100',
        });
        $(function() {
            $("#skills-table").sortable({
                update: function(event, ui) {
                    var sorted_data = [];
                    $("#skills-table tr").each(function(k, elem) {
                        const id = parseInt($(this).data('id'));
                        const order = k;
                        sorted_data.push({
                            id,
                            order
                        })
                    })
                    $.ajax({
                        method: 'post',
                        data: {
                            sorted_data
                        },
                        url: "{{ route('admin.user-skills.order') }}",
                        success: function(response) {
                            if (response.status) {
                                $('#skills-names').html('')
                                const skills = response.data.skills;
                                skills.map(function(skill){
                                    skill_append(skill.skill)
                                    // $('#skills-names').append(`<li>${skill_name}</li>`)
                                })
                                setDifferentLiColors()
                                $('.reorder-message').text(response.message).addClass('show');
                                setTimeout(function(){  $('.reorder-message').removeClass('show').text(''); },3000)
                            }
                        }
                    })
                }
            }).disableSelection();
        });

    </script>
@endsection
@endsection
