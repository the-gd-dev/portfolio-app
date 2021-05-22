const email_services_ul = `<ul class="email-services show list-unstyled"></ul>`;

$(document).on('input', '[name="email"]', async function () {
    const email_add = $(this).val().trim();
    $('.email-services').remove();
    $(this).after(email_services_ul);
    let $emailServicesContainer = $('.email-services');
    if (email_add.includes('@')) {
        let index = email_add.indexOf('@');
        let afterat = email_add.substr(index + 1);
        if ($emailServicesContainer.children().length == 0) {
            const { emailservices } = await $.get(getEmailServices);
            $.each(emailservices, function (_, service) {
                const option = `
                    <li value="${service}">${service}</li>
                `;
                $emailServicesContainer.append(option);
            })
        }
        (!afterat) ? 
            $emailServicesContainer.addClass('show') : 
                $emailServicesContainer.remove();
    }
})
$(document).on('click', '.email-services li', function () {
    let email_add = $('[name="email"]').val();
    let index = email_add.indexOf('@');
    email_add = email_add.substr(0, index + 1);
    email_add += $(this).attr('value');
    $('[name="email"]').val(email_add);
    $('.email-services').remove();
});