
// check variable valdidaty
const checkvariable = (variable) => !(variable == null || variable == undefined || variable == '');
//Error Codes 
const errorCodes = [500, 400, 422, 429, 404, 401, 419];
//Error Codes Messages Headings
const toasterText = {
    404: { heading: 'Resource not found.', text: 'The resource you\'re trying to access does not exist.' },
    401: { heading: 'You\'re not authorised.', text: 'You\'re not authorised to access this resource.' },
    422: { heading: 'You\'ve unresolved errors.', text: 'Please check the form you\'re trying to submit.' },
    429: { heading: 'Too many requests.', text: 'Please check after some time. Server wants rest.' },
    419: { heading: 'CSRF Token Mismatched', text: 'Please refresh your page and retry again.' },
    500: { heading: 'Internal Server Error !!!', text: 'Sorry for the inconvinience we\'re working on it.' },
};
function calculateAge(birthday) { // birthday is a date
    var ageDifMs = Date.now() - birthday;
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}
//Ajax Setup of Headers
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error :function(error){
        const response = error.responseJSON;
        const ErrCode = parseInt(error.status);
        toasterMsg({
            icon: 'error',
            heading: toasterText[ErrCode].heading,
            text: toasterText[ErrCode].text,
            bg_color: '#ff8381'
        });
    }
})

async function deleteSwal(ic = null, tle = null, txt = null) {
    const response = await Swal.fire({
        icon: ic ? ic : 'info',
        title: tle ? tle : 'Are you sure ?',
        text: txt ? txt : 'you want to delete.',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    })
    return response;
}

function sortAscByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}


$(document).ready(function () {
    // Show Form Errors
    function showFormErrors(errors, formId, customFunction = null) {
        $('label.is-invalid').remove();
        $('.is-invalid').removeClass('is-invalid');
        $.each(errors, (field, error) => {
            $(formId).find(`[name='${field}']`).addClass('is-invalid');
            $(formId).find(`[name='${field}']`).after(`<label id="${field}-error" class="is-invalid" for="${field}">${error}</label>`);
        })
        if (customFunction) { customFunction(); }
    }
    //custom ajax form submit 
    $.fn.ajaxForm = function (options) {
        var _self = this;
        if (options.hasOwnProperty('customErrorShow')) {
            options.customErrorShow();
        }
        this.validate({
            errorClass: "is-invalid",
            ignore: [".validate-hidden"],
            rules: options.rules ? options.rules : {},
            submitHandler: function (form) {
                const $form = $(form);
                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: $form.serialize(),
                    beforeSend: function () {
                        if (options.hasOwnProperty('beforeSend')) {
                            options.beforeSend();
                            return false;
                        }
                        $(_self).find('button .spinner-border').show();
                    },
                    success: function (response) {
                        //Success Form
                        if (response.status) {
                            if (options.hasOwnProperty('handleSuccess')) {
                                options.handleSuccess(response);
                                return false;
                            }
                            return false;
                        }
                        // Toaster Custom Error
                        if (response.toast) {
                            if (options.hasOwnProperty('handleToasterErrors')) {
                                options.handleToasterErrors(response);
                                return false;
                            }
                            toasterMsg({
                                icon: 'error',
                                heading: 'Internal Server Error !!',
                                text: 'Have patience we are working on it.',
                            });
                            return false;
                        }
                        // Custom Form Errors
                        if (response.errors && response.form_errors) {
                            let formId = `#${$(form).attr('id')}`
                            if (options.hasOwnProperty('handleFormErrors')) {
                                options.handleFormErrors(response.errors, formId);
                                return false;
                            }
                            if (options.hasOwnProperty('customErrorShow')) {
                                showFormErrors(response.errors, formId, options.customErrorShow())
                                return false;
                            }
                            showFormErrors(response.errors, formId)
                            return false;
                        }
                    },
                    // Handle Server Errors
                    error: function (error) {
                        const response = error.responseJSON;
                        const ErrCode = parseInt(error.status);
                        const formId = `#${$(form).attr('id')}`;
                        if (options.hasOwnProperty('handleServerErrors')) {
                            options.handleServerErrors(response);
                            return false;
                        }
                        if (errorCodes.includes(ErrCode)) {
                            if (options.hasOwnProperty('handleFormErrors')) {
                                options.handleFormErrors(response.errors, formId);
                                return false;
                            }
                            toasterMsg({
                                icon: 'error',
                                heading: toasterText[ErrCode].heading,
                                text: toasterText[ErrCode].text,
                                bg_color: '#ff8381'
                            });
                            if (options.hasOwnProperty('customErrorShow')) {
                                showFormErrors(response.errors, formId, options.customErrorShow())
                                return false;
                            }
                            showFormErrors(response.errors, formId)
                            setTimeout(() => { $('.success-message').removeClass('active') }, 3000);
                            $(_self).find('button .spinner-border').hide();
                        }
                    },
                    complete: function (e) {
                        if (options.hasOwnProperty('onComplete')) {
                            options.beforeSend();
                            return false;
                        }
                        setTimeout(() => { $('.success-message').removeClass('active') }, 3000);
                        $(_self).find('button .spinner-border').hide();
                    }
                });
                return false;
            }

        });
        return false;
    };

    // Special Functions
    $(document).on('keyup',"input[data-numeric='true']",function () {
        const strippedNonNumerics = $(this).val().replace(/(,D|[^\d]+)+/g, '');
        $(this).val(strippedNonNumerics);
    });

    // Special Functions
    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "A-Z allowed only");

    // Direct Image Upload
    $(document).on('change', '.direct-image-upload', function (e) {
        var formDataStore = new FormData();
        var _self = $(this);
        var maxFileValidation = true;
        const img_loader = $(this).data('loader');
        const action = $(this).data('action');
        var dataView = $($(this).data('image-view'));
        var bar = $('.bar');
        formDataStore.append("image", e.target.files[0]); 
        // if specific data required
        if ($(this).attr('data-target-id')) { formDataStore.append("target_db_id", $(this).attr('data-target-id')) }
        if ($(this).attr('data-target-section')) { formDataStore.append("target_db_section", $(this).attr('data-target-section')); }
        if ($(this).attr('data-ignore')) { formDataStore.append("ignore", $(this).attr('data-ignore')); }
        if (maxFileValidation) {
            $.ajax({
                url: action,
                method: "POST",
                data: formDataStore,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $(img_loader).show();
                    dataView.hide();
                },
                error: function () {
                    _self.parent().find('.dropzone-message').show();
                },
                success: function (response) {
                    _self.parent().find('.dropzone-message').hide();
                    const n = _self.attr('data-hidden-field');
                    if (n) { $('[name="' + n + '"]').val(response.data.url).trigger('change'); }
                    dataView.attr('src', response.data.url);
                    $(img_loader).hide();
                    dataView.show();
                    _self.parent().addClass('has-file');
                },
            });
            bar.hide();
            dataView.parent().find('loader').hide();
        }

    });


    // Simple Image Upload
    $(document).on('change', '.simple-image-upload', function (e) {
        var dataView = $($(this).data('image-view'));
        var file = e.target.files[0];
        var fr = new FileReader();
        dataView.hide()
        dataView.parent().hide()
        fr.onload = function (e) {
            dataView.attr('src', e.target.result);
            if ($('.dropzone')) {
                $('.dropzone').addClass('has-file');
                $('.is-invalid-file').remove();
                $('.dropzone').find('.dropzone-message').html('Click Or Drop Your file Here').hide();
            }
        }
        fr.readAsDataURL(file);
        dataView.show()
        dataView.parent().show()
        dataView.parent().find('loader').hide();
    });

})


// For Toaster Messages  

function toasterMsg(data) {
    $.toast({
        text: checkvariable(data.text) ? data.text : '',
        heading: checkvariable(data.heading) ? data.heading : 'Oops...',
        icon: checkvariable(data.icon) ? data.icon : 'success',
        showHideTransition: checkvariable(data.trans) ? data.trans : 'fade',
        allowToastClose: true,
        hideAfter: checkvariable(data.delay) ? data.delay : 3000,
        stack: 5,
        position: checkvariable(data.position) ? data.position : 'top-right',
        textAlign: 'left',
        loader: true,
        loaderBg: checkvariable(data.bg_color) ? data.bg_color : '#df4e4e',
        beforeShow: function () { },
        afterShown: function () { },
        beforeHide: function () { },
        afterHidden: function () { }
    });
}

// On * Modal Close Event
$('.modal').on('hidden.bs.modal', function (e) {
    $('.modal').find('form .form-group .form-control.is-invalid').removeClass('is-invalid');
    $('.modal').find('form .form-group label.is-invalid').remove();
    $('.modal').find('form').trigger('reset');
})

function removeItems(elem) {
    elem.removeClass('is-invalid');
    elem.parent().find('label.is-invalid').remove();
}

// $(document).on('blur','form input', function(){  removeItems($(this)); })
// $(document).on('blur','form textarea', function(){ removeItems($(this)); })
// $(document).on('blur','form select', function(){ removeItems($(this)); })

