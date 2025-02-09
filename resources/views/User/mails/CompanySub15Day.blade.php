<h2>{{ $subject }}</h2>

<h3>Dear {{ $company_name }}</h3>

<br><br>

<p>Your {{ config('global.used_app_name', 'Tawredaat') }} membership expires in 15 days, and we sincerely hope that you
    will join us for another outstanding year of our great programs and professional development.
    Please let us know if you have questions or concerns.



</p>
<br>
<p>
    Sincerely,
    <br>
    {{ config('global.used_app_name', 'Tawredaat') }} Team
</p>
<img src="{{ asset('storage/' . $site_logo) }}" class="img-fluid" alt="" />
