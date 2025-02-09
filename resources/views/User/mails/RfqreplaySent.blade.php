<h2>{{ $subject }}</h2>

<h3>Dear {{ $company_name }}</h3>

<br><br>

<p>Your offer has been sent successfully to {{ $user_first_name }}.


</p>
<br>
<p>
    Thanks
    <br>
    {{ config('global.used_app_name', 'Tawredaat') }} Team
</p>
<img src="{{ asset('storage/' . $site_logo) }}" class="img-fluid" alt="" />
