// pagination handeling
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    const $tableWrapper = $('#dataListing')
    showTableLoader($tableWrapper);
    var url = $(this).attr('data-href');
    $.get(url, function (data) {
        hideTableLoader($tableWrapper);
        $tableWrapper.html(data.appendHtml);
    });
});

// Search Box
$(document).on('input', '#search-data', function (e) {
    e.preventDefault();
    const $tableWrapper = $('#dataListing')
    showTableLoader($tableWrapper);
    var url = $(this).attr('data-action');
    var inputVal = $(this).val().trim();
    $.get(url + '?search=' + inputVal, function (data) {
        $tableWrapper.html(data.appendHtml);
    });
});

//function to show loader
function showTableLoader($wrapper) {

    const loader = `<div class="text-center" id="loader">
                <div class="spinner-border spinner-border-lg icons-loader" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;
    $wrapper.html(loader);

}

//function to hide loader
function hideTableLoader($wrapper) {
    if ($wrapper.find('#loader')) {
        $wrapper.find('#loader').remove();
        $wrapper.show();
    }
}
//initial table load
$(document).ready(function () {
    const $tableWrapper = $('#dataListing')
    showTableLoader($tableWrapper);
    $.get('', function (data) {
        hideTableLoader($tableWrapper);
        $tableWrapper.html(data.appendHtml);
        data.count > 0 ? $('.renderable').show() : $('.renderable').hide();
        $('[data-toggle="tooltip"]').tooltip();
    });

})
//bulk actions script
const get_checked = () => {
    return $('.bulk-action.single:checked').length
}
const get_unchecked = () => {
    return $('.bulk-action.single:not(:checked)').length
}
$(document).on('click', '.bulk-action.all', function () {
    var is_checked = $(this).is(':checked');
    const $singleChecks = $('.bulk-action.single');
    $singleChecks.prop('checked', false)
    is_checked ? $singleChecks.prop('checked', true) : null;
    set_bulk_data();
})
var bulk_data = '';
const bulk_actions = {};
function set_bulk_data() {
    bulk_data = [];
    $('.bulk-action.single:checked').each(function (k, cb) {
        bulk_data.push($(cb).val().trim());
    });
    if (get_checked() == 0) {
        if (bulk_actions && bulk_actions.hasOwnProperty('remove')) {
            bulk_actions.remove();
        } else {
            $('.bulk-action-btn').hide();
        }
    } else {
        if (bulk_actions && bulk_actions.hasOwnProperty('action')) {
            bulk_actions.action(bulk_data);
        } else {
            $('.bulk-action-btn').show();
        }
    }

}
$(document).on('click', '.bulk-action.single', function () {
    const $checkAll = $('.bulk-action.all');
    const $singleChecks = $('.bulk-action.single');
    var is_checked = $(this).is(':checked');
    $checkAll.prop('checked', false);
    if ($singleChecks.length == get_checked() && is_checked) {
        $checkAll.prop('checked', true)
    }
    set_bulk_data();
})

$(document).on('click', '.bulk-action-btn', async function () {
    const action = $(this).data('action');
    if (action) {
        const swal_text = bulk_data.length > 1 ? `
            This is a bulk action it will take a while. \n
            Are you sure ?
        `: null;
        const swal_heading = bulk_data.length > 1 ? 'This action is a bulk action !' : '';
        const { isConfirmed } = await deleteSwal('info', swal_heading, swal_text);
        if (isConfirmed) {
            const response = await $.post(action, { payload: bulk_data });
            if (response.status) {
                toasterMsg({
                    heading: response.message,
                    text: 'Bulk Actions Completed',
                    bg_color: '#62f764'
                });
                $('#dataListing').html(response.data.appendHtml);
                set_bulk_data();
            }
        }
    }

})