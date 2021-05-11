// Qualifications Start
var $qualifications_container = $('#qualifications-container');
var $experiences_container = $('#experiences-container');
const noEducationDiv = `
    <div class="row">
        <div class="col-sm-12 p-4">
            <h6>No qualifications added</h6>
            <small>Click button below to add.</small>
        </div>
    </div>
`;

const noExperienceDiv = `<div class="row">
    <div class="col-sm-12 p-4">
        <h6>No experiences added</h6>
        <small>Click button below to add.</small>
    </div>
</div>`;

$(document).on('click', '.add-education', async function () {
    $qualifications_container.hide();
    $(this).find('.spinner-border').show();
    const response = await $.post(urls.qualification.add, { resume_id: $(this).data('id') });
    $qualifications_container.html(response.appendHtml);
    $(this).find('.spinner-border').hide();
    $qualifications_container.show();
    $qualifications_container.parent().scrollTop($qualifications_container.height());
})

$(document).on('click', '.delete-education', async function () {
    const education_id = $(this).data('id');
    const { isConfirmed } = await deleteSwal();
    if (isConfirmed) {
        const response = await $.post(urls.qualification.remove, { education_id })
        if (response.status) {
            $(`.ed-${education_id}`).remove();
            const qualifcationsLength = $qualifications_container.children().length;
            if (qualifcationsLength == 0) {
                $qualifications_container.html(noEducationDiv);
            }
        }
    }

})
//Inputs
$(document).on('blur', '.institute',  function () {
    const institute = $(this).val();
    const education_id = $(this).parent().data('id');
    saveQualification({
        institute,
        education_id
    })
})

$(document).on('blur', '.course',  function () {
    const course = $(this).val();
    const education_id = $(this).parent().data('id');
    saveQualification({
        course,
        education_id
    })
})

$(document).on('blur', '.course_description',  function () {
    const course_description = $(this).val();
    const education_id = $(this).parent().data('id');
    saveQualification({
        course_description,
        education_id
    })

})

$(document).on('change', '.from_date',  function () {
    const education_id = $(this).parent().data('id');
    const from_date = $(this).val();
    saveQualification({
        from_date,
        education_id
    })
})

$(document).on('change', '.to_date',  function () {
    const education_id = $(this).parent().data('id');
    const to_date = $(this).val();
    saveQualification({
        to_date,
        education_id
    })
})
$(document).on('change', '.is_shown',  function () {
    const is_shown = $(this).is(':checked') ? 1 : 0 ;
    const education_id = $(this).parent().data('id');
    saveQualification({
        is_shown,
        education_id
    })
})
function saveQualification(data){
    const id = data.education_id;
    const container = $(`.ed-${id}`);
    container.find('.data-status .saving').show();
    $.post(urls.qualification.save, data)
     .then(function(response){
        if (response.status) {
            container.find('.data-status .saving').hide();
            container.find('.data-status .saved').show();
            setTimeout(() => {
                container.find('.data-status .saved').hide();
            }, 2000);
            return false;
        }
     })
    container.find('.data-status .saving').hide();
    container.find('.data-status .saved').hide();
}
// Qualifications End
// Experiences Start
$(document).on('click', '.add-experience', async function () {
    $experiences_container.hide();
    $(this).find('.spinner-border').show();
    const response = await $.post(urls.experience.add, { resume_id: $(this).data('id') });
    $experiences_container.html(response.appendHtml);
    $(this).find('.spinner-border').hide();
    $experiences_container.show();
    $experiences_container.parent().scrollTop($experiences_container.height());
})

$(document).on('click', '.delete-experience', async function () {
    const experience_id = $(this).data('id');
    const { isConfirmed } = await deleteSwal();
    if (isConfirmed) {
        const response = await $.post(urls.experience.remove, { experience_id })
        if (response.status) {
            $(`.qual-${experience_id}`).remove();
            const qualifcationsLength = $qualifications_container.children().length;
            if (qualifcationsLength == 0) {
                $qualifications_container.html(noEducationDiv);
            }
        }
    }

})

//Inputs
$(document).on('blur', '.position',  function () {
    const position = $(this).val();
    const experience_id = $(this).parent().data('id');
    saveExperienceData({
        position,
        experience_id
    })
})

$(document).on('blur', '.course',  function () {
    const course = $(this).val();
    const experience_id = $(this).parent().data('id');
    saveExperienceData({
        course,
        experience_id
    })
})

$(document).on('change', '.from_date_ex',  function () {
    const experience_id = $(this).parent().data('id');
    const from_date = $(this).val();
    saveExperienceData({
        from_date,
        experience_id
    })
})

$(document).on('change', '.to_date_ex',  function () {
    const experience_id = $(this).parent().data('id');
    const to_date = $(this).val();
    saveExperienceData({
        to_date,
        experience_id
    })
})


$(document).on('blur', '.company_name',  function () {
    const company_name = $(this).val();
    const experience_id = $(this).parent().data('id');
    saveExperienceData({
        company_name,
        experience_id
    })

})

$(document).on('blur', '.company_address',  function () {
    const company_address = $(this).val();
    const experience_id = $(this).parent().data('id');
    saveExperienceData({
        company_address,
        experience_id
    })

})
$(document).on('blur', '.responsibilities',  function () {
    const responsibilities = $(this).val();
    const experience_id = $(this).parent().data('id');
    saveExperienceData({
        responsibilities,
        experience_id
    })

})
$(document).on('change', '.is_shown_exp',  function () {
    const is_shown = $(this).is(':checked') ? 1 : 0 ;
    const experience_id = $(this).parent().data('id');
    saveExperienceData({
        is_shown,
        experience_id
    })
})
function saveExperienceData(data){
    const id = data.experience_id;
    const container = $(`.qual-${id}`);
    container.find('.data-status .saving').show();
    $.post(urls.experience.save, data)
     .then(function(response){
        if (response.status) {
            container.find('.data-status .saving').hide();
            container.find('.data-status .saved').show();
            setTimeout(() => {
                container.find('.data-status .saved').hide();
            }, 2000);
            return false;
        }
     })
    container.find('.data-status .saving').hide();
    container.find('.data-status .saved').hide();
}
// Experiences End

$(document).ready(function(){
    var ckEditor = CKEDITOR.replace('resume_summery', {
        height: '120',
    });
})
