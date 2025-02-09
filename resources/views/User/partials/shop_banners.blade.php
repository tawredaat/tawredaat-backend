<div class="home-slider">
    @foreach ($shop_banners as $banner )
    <div>
        <img src=" {{ $banner->img }} "  alt="{{$banner->alt}}" style="object-fit: contain;" />
    </div>
    @endforeach

</div>
