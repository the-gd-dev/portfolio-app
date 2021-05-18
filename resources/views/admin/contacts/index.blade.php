@extends('layouts.auth-admin')
@section('content')
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: 'Contact Form Settings Updated !!',
                        bg_color: '#62f764'
                    });
                    $('#contactsSettings').modal('hide');
                }
            }
        }

    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <div class="row  justify-content-between">
                            <div class="col-lg-2 text-md-left">
                                <h6 class="mt-2 font-weight-bold text-primary"><i class="fa fa-envelope"></i> Contacts</h6>
                            </div>
                            <div class="col-lg-8 text-md-right">
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-lg-2">
                                        <input type="text" data-action="{{ route('admin.contact-form.store') }}"
                                            placeholder="search name or email" id="search-data" class="form-control" />
                                    </div>
                                    <div class="col-lg-1">
                                        <a href="Javascript:void(0);"
                                            class="btn text-lg btn-light border btn-block btn-sm mt-2 mt-md-0"
                                            id="contactsSettingsButton">
                                            <i class="fa fa-cog"></i>
                                            <div class="d-inline-block d-lg-none ">
                                                Settings
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12" id="dataListing">
                                @include('admin.contacts.listing')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service Settings Modal-->
    <div class="modal fade" id="contactsSettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-cogs"></i> Contact Form Basic Settings
                    </h6>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center" id="data-loader">
                            <div class="spinner-border spinner-border-xl" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span class="h5 d-block mt-4 text-dark">
                                loading settings please wait ...</span>
                        </div>
                        <div class="col-sm-12 px-4">
                            <form action="{{ route('admin.contacts.settings') }}" method="POST" id="contactsSettingsForm">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-end">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="hide_contact_form"
                                                        class="custom-control-input active_status_portfolio"
                                                        id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">Hide Contact
                                                        Form
                                                        Section </label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label>Change Header Title
                                                    <span data-toggle="tooltip"
                                                        title="Change the main heading text from 'CONTACT ME'. ">
                                                        <i class="fa fa-info-circle"></i></span>
                                                </label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="header_title[apply]" value="1" />
                                                </label>
                                            </div>
                                            <input type="text" autocomplete="" class="form-control"
                                                name="header_title[value]">
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label><i class="fa fa-location"></i> Location</label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="location[apply]" value="1" />
                                                </label>
                                            </div>
                                            <textarea autocomplete="" name="location[value]"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label>Email <span data-toggle="tooltip" title="By default we are using your email will recieve contacts information. 
                                                                        However, you can change it here.">
                                                        <i class="fa fa-info-circle"></i></span></label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="email[apply]" value="1" />
                                                </label>
                                            </div>
                                            <input autocomplete="" name="email[value]" class="form-control" type="email" />
                                        </div>
                                        <div class="col-md-12 pb-4">
                                            <div class="d-flex justify-content-between">
                                                <label>Call</label>
                                                <label>
                                                    Apply
                                                    <input type="checkbox" name="phone[apply]" value="1" />
                                                </label>
                                            </div>
                                            <input 
                                                id="phonenumber" 
                                                data-numeric="true" 
                                                name="phone[value]"
                                                type="text" maxlength="10"
                                                minlength="10" class="form-control" 
                                            />
                                            <input id="countrycode" data-numeric="true" name="country[value]"
                                                    value='{"name":"United States","iso2":"us","dialCode":"1","priority":0,"areaCodes":null}'
                                                    type="hidden" class="form-control" />
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-light border category-btn btn-block"
                                        onclick="$('#contactsSettingsForm').ajaxForm(ResponseHandeling);">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        Save Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@section('scripts')
    <script>
        //Portfolio Settings Fetch 
        $(document).on('click', '#contactsSettingsButton', async function() {
            const $thisModal = $('#contactsSettings');
            $thisModal.modal('show')
            $thisModal.find('#data-loader').show();
            $thisModal.find('#contactsSettingsForm').hide();
            const response = await $.get('contacts-settings');
            if (response.hasOwnProperty('data')) {
                $.each(response.data, (k, v) => {
                    if(k == 'country'){
                        $("#phonenumber").intlTelInput({initialCountry : JSON.parse(v.value).iso2});
                        $(`[name="country[value]"]`).val(v.value);
                    }
                    else if (k == 'hide_contact_form') {
                        v.value == '1' ?
                            $('[name="hide_contact_form"]').attr('checked', true) :
                            $('[name="hide_contact_form"]').removeAttr('checked');
                    } else {
                        $(`[name="${k}[value]"]`).val(v.value);
                        v.apply == '1' ?
                            $(`[name="${k}[apply]"]`).attr('checked', true) :
                            $(`[name="${k}[apply]"]`).removeAttr('checked');
                    }
                })
            }
            $thisModal.find('#data-loader').hide();
            $thisModal.find('#contactsSettingsForm').show();

        })
        $("#phonenumber").on('countrychange', function(v) {
            const num = $("#phonenumber").intlTelInput("getSelectedCountryData")
            $('#countrycode').val(JSON.stringify(num))
        })

    </script>
@endsection
@endsection
