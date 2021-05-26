

$(document).on('click', '.cat__delete, .portfolio__delete', function () {
   $('#deleteModal').modal('show');
   $('#deleteModal').find('form').attr('action', $(this).data('action'))
})



