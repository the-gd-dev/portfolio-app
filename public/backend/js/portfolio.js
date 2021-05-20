
const noItemsHTML = `<tr>
 <td colspan="4">
     <div class="p-4">
         No Portfolio Categories Found <br>
         <small class="text-muted">
             Click &nbsp;
                 <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#profileModal">
                     + Create New
                 </a>
             &nbsp;
             button to add portfolio category.
         </small>
     </div>
 </td>
</tr>`;
$(document).ready(function () {
    $('#profileModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-header h5').html(modal_titles.add);
        $(this).find(`input[name="category_id"]`).val('')
        $(this).find(`input[name="name"]`).val('')
        $(this).find('.category-btn').text('Add Category')
    })
    $('#projectDetails').on('hidden.bs.modal', function () {
        const $frame = $('#project_details');
        $frame.attr('src', '');
    })
})
$(document).on('click', '.cat__delete, .portfolio__delete', function () {
    $('#deleteModal').modal('show');
    $('#deleteModal').find('form').attr('action', $(this).data('action'))
})
$(document).on('click', '.cat__edit', function () {
    const data_text = $(this).parent().parent().prev().prev().text().trim();
    const data_id = $(this).parent().data('id');
    $('#profileModal').find('.modal-header h5').html(modal_titles.update)
    $('#profileModal').find(`input[name="category_id"]`).val(data_id)
    $('#profileModal').find(`input[name="name"]`).val(data_text)
    $('#profileModal').modal('show');
    $('#profileModal').find('.category-btn').text('Update Category')
})


$(document).on('change', '.active_status_cat',  function () {
    const _self = $(this);
    const url = $(this).data('url') ;
    const is_active = $(this).is(':checked') ? 1 : 0 ;
    $.post(url,{is_active, _method: 'PUT'}).then(response => {
        _self.next().text(`${is_active == 1 ? 'Active' : 'Inactive'}`);
    })
})

// Profile filter
$(document).on('change', '#CategoriesFilter', function (e) {
    e.preventDefault();
    const $tableWrapper = $('#dataListing')
    var url = $(this).attr('data-action');
    var inputVal = $(this).val().trim();
    showTableLoader( $tableWrapper);
    $.get(url + '?cat_filter=' + inputVal, function (data) {
        $tableWrapper.html(data.appendHtml);
    });
});

//Portfolio Settings Fetch 
$(document).on('click', '#portfolioSettingsButton', async function(){
    const $thisModal = $('#portfolioSettings');
    $thisModal.modal('show')
    $thisModal.find('#data-loader').show();
    $thisModal.find('#portfolioSettingsForm').hide();
    const response  = await $.get('portfolio-settings');
    if(response.hasOwnProperty('data')){
        $.each(response.data,(k,v ) => {
            if(k == 'hide_portfolio'){
                v.value == '1' ?
                $('[name="hide_portfolio"]').attr('checked',true) :
                $('[name="hide_portfolio"]').removeAttr('checked') ;
            }else{
                $(`[name="${k}[value]"]`).val(v.value);
                v.apply == '1' ?
                $(`[name="${k}[apply]"]`).attr('checked',true) :
                $(`[name="${k}[apply]"]`).removeAttr('checked') ;
            }
        })
    }
    $thisModal.find('#data-loader').hide();
    $thisModal.find('#portfolioSettingsForm').show();
    
})

$(document).on('click', '.btn__show, .link__show', function(){
    const $modal = $('#projectDetails');
    const $loader = $modal.find('.spinner');
    const url  = $(this).data('action');
    const $frame = $('#project_details');
    $frame.attr('src', url);
    $frame.show();
    $modal.modal('show')
})
