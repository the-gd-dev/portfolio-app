<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="thead-blue">
                <th style="width: 15%;">Name</th>
                <th style="width: 15%;">Email</th>
                <th style="width: 25%;">Subject</th>
                <th style="width: 45%;">Message</th>
            </thead>
            <tbody>
                @if (isset($contacts) && $contacts->count() > 0)
                    @foreach ($contacts as $contact)
                        <tr >
                            <td class="text-capitalize">{{ $contact->name ?? '' }}</td>
                            <td class="text-capitalize">{{ $contact->email ?? '' }}</td>
                            <td class="text-capitalize">{{ $contact->subject ?? '' }}</td>
                            <td class="text-capitalize">{{ $contact->message ?? '' }}</td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="2">
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


