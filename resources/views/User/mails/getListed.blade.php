<h2>{{ $subject }}</h2>

<h3>Dear {{ $companyName }}</h3>

<br><br>

<p>Thanks for Choosing SouqKahraba.com to List your Company. We wish you a beneficial collaboration.
    We would like to inform you that one of our Sales Members will Contact you Soon!

</p>
<br>
<p>
    Best Regards,
    <br>
    {{ config('global.used_app_name', 'Tawredaat') }} Team
</p>
<img src="{{ asset('storage/' . $site_logo) }}" class="img-fluid" alt="" />
