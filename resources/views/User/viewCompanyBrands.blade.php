 {{-- @if(isLogged()) --}}
<a href="{{urldecode(route('user.brand',['name'=>str_replace([' ','/'], '-',$brand->translate('en')->name),'id'=>$brand->id])) }}" class="brand-card card">
  <img   width="400" height="300" class="img-fluid lazyload" data-src="{{ asset('storage/'.$brand->image) }}" alt="{{$brand->alt}}"
       />
  <div class="details">
    <div class="name">
      <img data-src="{{ asset('frontend_plugins/web/images/right-mark.png')}}" class="lazyload" alt="name-icon" /> {{$brand->name}}
    </div>
    <div class="country">
      @if($brand->country)
      <img width="30" data-src="{{ asset('storage/'.$brand->country->flag) }}" class="lazyload" alt="{{$brand->country->alt}}" /> {{$brand->country->name}}
      @endif
    </div>
  </div>
</a>
{{-- @else
<a href="{{route('login')}}" class="brand-card card">
  <img
      width="400" height="300"
       class="img-fluid lazyload"
       data-src="{{ asset('storage/'.$brand->image) }}"
       alt="{{$brand->alt}}"
       />
  <div class="details">
    <div class="name">
      <img data-src="{{ asset('frontend_plugins/web/images/right-mark.png')}}" class="lazyload" alt="name-icon" /> {{$brand->name}}
    </div>
    <div class="country">
      @if($brand->country)
      <img width="30" data-src="{{ asset('storage/'.$brand->country->flag) }}" class="lazyload" alt="{{$brand->country->alt}}" /> {{$brand->country->name}}
      @endif
    </div>
  </div>
</a>
@endif --}}
