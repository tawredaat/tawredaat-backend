<h2>{{ $subject }}</h2>

<h3>Dear {{ $user_first_name }}</h3>

<br><br>

<p>You have received a reply for your RFQ of best prices of a product, kindly follow the following link, and log in with
    your user credentials to view the reply:
    <a href="{{ route('user.product.rfq.list') }}">URL</a>
</p>
<br>
<p>
    Have a nice Day!
    <br>
    {{ config('global.used_app_name', 'Tawredaat') }} Team
</p>
<img src="{{ asset('storage/' . $site_logo) }}" class="img-fluid" alt="" />
