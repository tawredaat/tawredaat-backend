<h2>{{ $subject }}</h2>

<h3>Dear {{ $companyName }}</h3>

<br><br>

<p>You have received a new Request for quotation, kindly follow the following link, and log in with your company admin
    credentials to view the request:
    <a href="https://souqkahraba.com/companies/rfq-details/{{ $rfq_id }}">URL</a>
    Answering your Client Quickly makes a good reputation of your Company, Hurry up and reply to the Client!


</p>
<br>
<p>
    Best Regards,
    <br>
    {{ config('global.used_app_name', 'Tawredaat') }} Team
</p>
<img src="{{ asset('storage/' . $site_logo) }}" class="img-fluid" alt="" />
