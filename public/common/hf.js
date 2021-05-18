// check variable valdidaty
const checkvariable = (variable) => !(variable == null || variable == undefined || variable == '');
    

// For Toaster Messages  
const toasterMsg = (data) => {
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

$(document).ready(function () {
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
    //Ajax Setup of Headers
    $.ajaxSetup({
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function (error) {
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
})
