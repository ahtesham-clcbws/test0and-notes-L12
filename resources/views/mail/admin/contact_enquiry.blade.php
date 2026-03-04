<x-mail::message>
    Hello!
    <br>
    
    <div >
        <h2 style="color:rgb(35, 33, 33); text-align:center ">Success</h2>
        <p align="center" style="margin-top: 10px; color:rgb(35, 33, 33); text-align:center" id='message'>
            New Contact Enquiry {{ $contact->name }}  successfully sent!
        </p>
    </div>
    @component('mail::button', ['url' => route('administrator.manage.contactEnquiry')])
        Click To See
    @endcomponent
    <br> <br>
    Thanks
    Best regards,<br>
    {{ config('app.name') }}
</x-mail::message>
