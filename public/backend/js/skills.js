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
            const response = await $.get("/" + data_id + "/edit");
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
            const response = await $.post(chooseIconUrl, {skill_id, icon})
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
                const response  = await $.get(iconFetchUrl);
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
            await $.post(iconColors, data)
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
            await $.post(iconColors, data)
            $(target).css('color', color);
            $(target).attr('style', )
            $(this).parent().hide();
            $(this).parent().prev().attr('style', $(this).attr('style'));
        })