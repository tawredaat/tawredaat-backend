<a href="{{route('user.product',['brand'=>str_replace([' ','/'], '-',$product->brand?$product->brand->name:'brand'),'category'=>str_replace([' ','/'], '-',$product->category?$product->category->name:'category'),'id'=>$product->id,'name'=>str_replace([' ','/'], '-',$product->name)])}}" class="product-card card">
<!--   <img
      width="500" height="400" style="height: 300px"
       class="img-fluid"
       src="{{ asset('storage/'.$product->image) }}"
       alt="{{$product->alt}}"
       /> -->
       <div class="card-img" style="height: 200px;background-image:url('{{asset('storage/'.$product->image)}}');background-size: cover;    background-position-x: center; ">
       </div>
       <br>
  <h5 title="{{$product->name}}">{{$product->name}}</h5>
@foreach($product->companyProducts as $cp)
	@if($cp->company_id == $company->id AND $cp->price)
	  		<div class="price">{{$cp->price}}@lang('home.currency') {{$cp->unit?' / '.$cp->unit->name:''}}</div>
	@endif
@endforeach
</a> 
