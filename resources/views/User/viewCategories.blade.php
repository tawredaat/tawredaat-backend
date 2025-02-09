<!-- <div> -->
  <a href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$category->name),'id'=>$category->id])) }}" class="product-card card">
    <img
    class="img-fluid lazyload"
    data-src="{{ asset('storage/'.$category->image) }}"
    alt="{{$category->alt}}"
    />
    <h5>{{$category->name}}</h5>
  </a>

 {{--<div class="product-action-btn mt-1 mt-md-5">
    <a
      data-telephone="tel:0100000000000"
      class="primary-dark-fill text-nowrap m-2 call-company call-tel-style yellow-rounded"
      > 
      <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call-blue.svg')}}" 
        width="20" class="mr-2 d-inline" alt="phone">call Now</span>
      <span class="tel">0100000000000</span>
    </a>
    <a href="" class="primary-dark-fill primary-rounded m-2"> 
      <img width="22" class="mr-2 d-inline" src="{{ asset('frontend_plugins/web/images/Get-Price-icon.png')}}" 
      alt=""> Get Best Price</a>
    </div>
    <div>
      <a
      style="color:white"
      data-telephone="tel:010000000000000"
      class="primary-dark-fill w-100 sm-btn text-nowrap call-company call-tel-style"
      data-route="{{route('user.company-call')}}" 
      data-company="{{$company->id}}"
      >
      <span class="text"><img src="{{ asset('frontend_plugins/web/images/phone-call.svg')}}" width="17" class="mr-2 d-inline" alt="phone">@lang('home.callCompanyNow')</span>
      <span class="tel">010000000000000</span>
      </a>
    </div>--}}

<!-- </div> -->
