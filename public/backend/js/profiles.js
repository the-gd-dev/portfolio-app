       
 const noItemsHTML = `<tr>
 <td colspan="4">
     <div class="p-4">
         No Profiles Found <br>
         <small class="text-muted">
             Click &nbsp;
                 <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#profileModal">
                     + Create New
                 </a>
             &nbsp;
             button to add new profile.
         </small>
     </div>
 </td>
</tr>`;
$(document).ready(function() {
$('#profileModal').on('hidden.bs.modal', function() {
$(this).find('.modal-header h5').html(modal_titles.add);
$(this).find(`input[name="category_id"]`).val('')
$(this).find(`input[name="name"]`).val('')
$(this).find('.category-btn').text('Add Profile')
})
})
$(document).on('click', '.profile__delete', function() {
    $('#deleteModal').modal('show');
    $('#deleteModal').find('form').attr('action', $(this).data('action'))
})
$(document).on('click', '.profile__edit', function() {
const data_text = $(this).parent().parent().prev().text().trim();
const data_id = $(this).parent().data('id');
$('#profileModal').find('.modal-header h5').html(modal_titles.update)
$('#profileModal').find(`input[name="profile_id"]`).val(data_id)
$('#profileModal').find(`input[name="profile"]`).val(data_text)
$('#profileModal').modal('show');
$('#profileModal').find('.category-btn').text('Update Profile')
})
