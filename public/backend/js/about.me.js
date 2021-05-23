
$('#skills')
    .select2()
    .on('change', async function (e) {
        const skills = $(this).val();
        var loader2 = $('.skills-loader-2')
        resetSkils();
        const response = await $.get(skillsChange, {
            skills
        });
        if (response.hasOwnProperty('skills')) {
            if (response.skills.length > 0) {
                loader2.show();
                response.skills.map((skill, key) => {
                    const skill_name = skill.skill.skill;
                    const skill_id = skill.skill.id;
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
                                                            <output class="bubble" style="display:none;left: ${calLeft.toFixed(2)}px"> ${skill.skill_accuracy || 0}</output>
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
    .on('change', async function (e) {
        var loader1 = $('.skills-loader-1')
        const profiles = $(this).val();
        resetSkils();
        const response = await $.post(profileSkills, {
            profiles,
            skills: $('#skills').val()
        });

        if (response.hasOwnProperty('profiles') && response.profiles.length) {
            $('#skills').html('').hide();
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
//resetting skills 
function resetSkils() {
    $('#skills-names').html('');
    $('#skills-table').html('');
}
//appending skill names 
function skill_append(skill) {
    const appendHtml = `<li>
                        ${skill.icon && skill.icon != '' ? `<i class="${skill.icon}"></i>` : ''}
                        ${skill.skill}
                    </li>`;
    $('#skills-names').append(appendHtml)
}

//skills names with different background colours 
function setDifferentLiColors() {
    $('#skills-names li').each(function (k, li) {
        $(li).css('background', `rgb(13 ${10 * k} 185)`);
    })
}

//skill accuracy
$(document).on('input', '.range', function () {
    const bubble = $(this).next();
    const v = parseInt($(this).val());
    const calLeft = v > 0 ? (v * 2.6) - v : 0;
    bubble.css('left', calLeft.toFixed(2) + 'px')
    bubble.text(v);
})

//workprofile initial trigger
$('#work_profiles').val(workProfiles).trigger('change')

//about user summery
CKEDITOR.replace('about_summery', {
    height: '120',
});

//skills summery
CKEDITOR.replace('skills_summery', {
    height: '100',
});

//initialization of sorting
$(function () {
    $("#skills-table").sortable({
        update: function (event, ui) {
            var sorted_data = [];
            $("#skills-table tr").each(function (k, elem) {
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
                url: skillOrderChange,
                success: function (response) {
                    if (response.status) {
                        $('#skills-names').html('')
                        const skills = response.data.skills;
                        skills.map(function (skill) {
                            skill_append(skill.skill)
                        })
                        setDifferentLiColors()
                        $('.reorder-message').text(response.message).addClass('show');
                        setTimeout(function () {
                            $('.reorder-message').removeClass('show').text('');
                        }, 3000)
                    }
                }
            })
        }
    }).disableSelection();
});