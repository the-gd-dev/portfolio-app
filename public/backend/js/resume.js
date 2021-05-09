var $qualifications_container = $('#qualifications-container');

$(document).on('click' ,'.add-education' , async function(){
    $qualifications_container.hide();
    $(this).find('.spinner-border').show();
    const response  = await $.post(urls.qualification.add, {resume_id : $(this).data('id')});
    $qualifications_container.html(response.appendHtml);
    $(this).find('.spinner-border').hide();
    $qualifications_container.show();
    $qualifications_container.parent().scrollTop($qualifications_container.height());
})

$(document).on('click' ,'.add-education' , async function(){
    
})