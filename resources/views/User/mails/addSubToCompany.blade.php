<h2>{{ $subject }}</h2>

<h3>Dear {{ $company_name }}</h3>

<br><br>

<p>Thanks for Choosing SouqKahraba.com. We wish you a beneficial collaboration.
    We are thrilled to inform you that [{{ $sub_name }}] has been linked to your company.

    Your company profile is now live on our website through this link:
    <br>
    <a
        href="{{ urldecode(route('user.company', ['name' => str_replace([' ', '/'], '-', $company_name), 'id' => $company_id])) }}">Link
    </a>

    <br>
    You can login to your company dashboard, using your credentials, in the Company Login Section, through:
    https://www.souqkahraba.com/login/

    Username: {{ $company_email }}
    <br>
    Password: {{ $code }}





</p>
<br>
<p>
    Best Regards,
    <br>
    {{ config('global.used_app_name', 'Tawredaat') }} Team
</p>
<img src="{{ asset('storage/' . $site_logo) }}" class="img-fluid" alt="" />
