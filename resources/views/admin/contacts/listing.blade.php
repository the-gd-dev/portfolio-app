<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
            <table class="table table-sm  ">
                <thead class="thead-blue">
                    <th><input type="checkbox" style="height: 16px; width: 16px;" class="bulk-action all"></th>
                    <th style="width: 15%;">Name</th>
                    <th style="width: 10%;">Email</th>
                    <th style="width: 20%;">Subject</th>
                    <th style="width: 35%;">Message</th>
                    <th style="width: 7%;">Status</th>
                    <th style="width: 13%;">Action</th>
                </thead>
                <tbody>
                    @if (isset($contacts) && $contacts->count() > 0)
                        @foreach ($contacts as $contact)
                            <tr>
                                <td><input value="{{ $contact->secret_id }}" class="bulk-action single"
                                        type="checkbox" style="height: 16px; width: 16px;"></td>
                                <td class="text-capitalize">{{ $contact->name ?? '' }}</td>
                                <td class="text-capitalize">{{ $contact->email ?? '' }}</td>
                                <td class="text-capitalize">{{ $contact->subject ?? '' }}</td>
                                <td class="text-capitalize">{{ $contact->message ?? '' }}</td>
                                <td class="">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" @if ($contact->email_checked == '1') checked @endif name="hide_service"
                                            data-url="{{ route('admin.contact-form.update', $contact->secret_id) }}"
                                            class="custom-control-input read_status_contacts" id="customSwitch{{$contact->secret_id}}">
                                        <label class="custom-control-label" for="customSwitch{{$contact->secret_id}}">
                                            @if ($contact->email_checked == '1')
                                                <span class="text-primary">read</span>
                                            @else
                                                <span class="text-muted">unread</span>
                                            @endif
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <a href="Javascript:void(0);"
                                        data-action="{{ route('admin.contact-form.destroy', $contact->secret_id) }}"
                                        class=" btn btn-sm cat__delete"><i class="fa fa-trash"> Delete</i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">
                                <div class="p-4">
                                    No Contacts Found <br>
                                    <small class="text-muted">
                                        When user will contact you via contact form you can see it here. <br>
                                        As well you will recieve an email.
                                    </small>
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    @if (isset($contacts) && $contacts->count() > 0)
        <div class="col-sm-12">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
