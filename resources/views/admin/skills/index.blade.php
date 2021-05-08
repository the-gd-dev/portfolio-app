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
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-suitcase"></i> Skill</h6>
                        <div class="d-inline-flex">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#skillModal">+ Create
                                New</button>
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
                        <input type="text"  placeholder="search icon ..." class="form-control" id="search_icon" />
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
        const noItemsHTML = `<tr>
                        <td colspan="2">
                            <div class="p-4">
                                No Profiles Found <br>
                                <small class="text-muted">
                                    Click &nbsp;
                                        <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#skillModal">
                                            + Create New
                                        </a>
                                    &nbsp;
                                    button to add new skill.
                                </small>
                            </div>
                        </td>
                    </tr>`;
        $(document).ready(function() {
            $('#skillModal').on('hide.bs.modal', function() {
                $(this).find('.modal-header h5').html(modal_titles.add);
                $('#skillModal').find(`input[name="skill_id"]`).val('')
                $('#skillModal').find(`select[name="profile_id"]`).val('')
                $('#skillModal').find(`input[name="skill"]`).val('')
                $('.category-btn').text('Add Skill')
            })
        })
        $(document).on('click', '.skill__delete', function() {
            $('#deleteModal').modal('show');
            $('#deleteModal').find('form').attr('action', $(this).data('action'))
        })
        $(document).on('click', '.skill__edit', async function() {
            const data_id = $(this).parent().data('id');
            const response = await $.get("{{ route('admin.skills.store') }}/" + data_id + "/edit");
            if (response.hasOwnProperty('skill')) {
                $('#skillModal').find('.modal-header h5').html(modal_titles.update)
                $('#skillModal').find(`input[name="skill_id"]`).val(response.skill.id)
                $('#skillModal').find(`select[name="profile_id"]`).val(response.skill.profile_id)
                $('#skillModal').find(`input[name="skill"]`).val(response.skill.skill)
                $('#skillModal').modal('show');
                $('.category-btn').text('Update Skill')
                return false;
            } else {
                toasterMsg({
                    icon: 'error',
                    heading: toasterText[404].heading,
                    text: toasterText[404].text,
                    bg_color: '#FFFFFF'
                });
            }

        })
        $(document).on('click', '.choose-icon', async function() {
            const skill_id = $(this).parent().attr('data-id');
            const icon     = $(this)[0].children[0].className;
            const response = await $.post("{{route('admin.skills.icons')}}", {skill_id, icon})
            if(response && response.hasOwnProperty('message')){
                toasterMsg({
                    heading: response.message,
                    text: "Skill has a new icon now.",
                    bg_color: '#FFFFFF'
                });
                $(`.change-icon-${skill_id}`).data('icon', icon).html(`<span class="icon-wrapper"> <i class="${icon}"></i></span>`);
            }
            $('#IconsModal').modal('hide');
        })
        $(document).on('hidden.bs.modal', '#IconsModal', function(){
            $('#search_icon').val('').trigger('input');
        })
        $(document).on('click', '.change-icon', async function() {
            const skill_id = $(this).data('id');
            const $loader = $('.icons-loader');
            const $iconWrapper = $('#icons-wrapper');
            const icon_match = $(this).data('icon');
            $('.choose-icon').removeClass('active');

            const is_icons = $('#icons-wrapper').children();
            $('#IconsModal').modal('show');
            $loader.show();
            if(!is_icons.length){
                $iconWrapper.html('')
                const response  = await $.get("{{route('icons.index')}}");
                
                if(response.icons){
                    response.icons.map(icon => {
                        const title = icon
                                      .replace('-','')
                                      .replace('fab fa','')
                                      .replace('-',' ')
                                      .replace('-',' ')
                                      .replace('icon','')
                                      .replace('alt','')
                                      .replace('devicon','')
                                      .replace('plain','')
                                      .replace('original','')
                                      .replace('-',' ')
                                      .replace('dev','')
                                      .trim();
                        const monoIconWrap =`<div class="col-3 col-md-2 col-lg-1 py-2 text-center choose-icon"  data-icon="${icon}">
                            <i class="${icon}" data-placement="top" data-toggle="tooltip" title="${title}"></i>
                        </div>`;
                        $iconWrapper.append(monoIconWrap);
                    })
                }
            }
            $('[data-toggle="tooltip"]').tooltip();
            $(`.choose-icon[data-icon="${icon_match}"]`).addClass('active');
            $iconWrapper.removeAttr('data-id');
            $iconWrapper.attr('data-id', skill_id);
            $loader.hide();
        })
        $(document).on('input', '#search_icon' , function(){
            $('#icons-wrapper').children().hide();
            const iconWc = $(this).val().trim();
            if(iconWc){
                $(`[data-icon*=${iconWc}]`).show();
                return false;
            }
            $('#icons-wrapper').children().show();
            
        })
        $(function(){
            $('.bcPicker').bcPicker();
            $('.bcPicker2').bcPicker();
        });
            
        $(document).on('click','.bcPicker-picker', function(){
            $('.bcPicker-palette').hide();
            $(this).next().show();
        })
        $(document).on('click','.bcPicker .bcPicker-color',async function(){
            const wrap_div = $(this).parent().parent();
            const target = wrap_div.attr('data-target');
            const id = target.split('-')[2];
            const color  = $(this).css('background-color');
            const data = {skill_id : id , background_color : color};
            await $.post("{{route('admin.skills.colors')}}", data)
            $(target).css('background-color', color);
            $(`.change-icon-${id}`).css('color' ,color)
            $(this).parent().hide();
            $(this).parent().prev().attr('style', $(this).attr('style'));
        })
        $(document).on('click','.bcPicker2 .bcPicker-color', async function(){
            const wrap_div = $(this).parent().parent();
            const target = wrap_div.attr('data-target');
            const color  = $(this).css('background-color');
            const id = target.split('-')[2];
            const data = {skill_id : id , text_color : color};
            
            await $.post("{{route('admin.skills.colors')}}", data)
            $(target).css('color', color);
            $(target).attr('style', )
            $(this).parent().hide();
            $(this).parent().prev().attr('style', $(this).attr('style'));
        })
    </script>
@endsection
@endsection
