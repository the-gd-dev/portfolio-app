@if (isset($contact_settings) && isset($contact_settings->hide_contact_form) && $contact_settings->hide_contact_form->value == '0')
    @php
        $heading = $contact_settings->header_title ?? '';
        $call = $contact_settings->phone ?? '';
        $country = $contact_settings->country ?? '';
        $location = $contact_settings->location ?? '';
        $email = $contact_settings->email ?? '';
        function validateInfo($item)
        {
            return isset($item) && !empty($item->value) && $item->apply != '0';
        }
    @endphp
    <script>
        const ResponseHandeling = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: "Thanx for your interest in my profile.",
                        text: "I'll contact you shortly.",
                        bg_color: '#62f764'
                    });
                    $('#contactsSettings').modal('hide');
                    $('#ContactME').trigger('reset');
                }
            }
        }

    </script>
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2> {{ validateInfo($heading) ?  $heading->value :  'Contact Me' }} </h2>
            </div>

            <div class="row mt-1 justify-content-center">
                @if (validateInfo($call) || validateInfo($location) || validateInfo($email))
                    <div class="col-lg-4">
                        <div class="info">
                            @if (validateInfo($location))
                                <div class="address">
                                    <i class="bi bi-geo-alt"></i>
                                    <h4>Location:</h4>
                                    <p>{!! $location->value !!}</p>
                                </div>
                            @endif
                            @if (validateInfo($email))
                                <div class="email">
                                    <i class="bi bi-envelope"></i>
                                    <h4>Email:</h4>
                                    <p>{!! $email->value !!}</p>
                                </div>
                            @endif
                            @if (validateInfo($email))
                                <div class="phone">
                                    <i class="bi bi-phone"></i>
                                    <h4>Call:</h4>
                                    <p>+{{ json_decode($country->value)->dialCode }} {!! $call->value !!}</p>
                                </div>
                            @endif
                        </div>

                    </div>
                @endif

                <div class="col-lg-8 mt-5 mt-lg-0">

                    <form action="{{ route('contacts.store') }}" method="post" id="ContactME" class="php-email-form">
                        @csrf
                        <input type="hidden" name="recipient" value="{{ $user_id }}">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                    required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"
                                required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit"
                                onclick="$('#ContactME').ajaxForm(ResponseHandeling)">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;position:relative;top:-3px;right:5px;">
                                    <span class="sr-only">Loading...</span>
                                </div> Send Message
                            </button></div>
                    </form>

                </div>

            </div>

        </div>
    </section>
@endif
