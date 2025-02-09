@foreach ($category_selected_childs as $_category_level2)
    <div class="level2-item-holder">
        <a href="{{urldecode(route('user.shop.category.l2.products',['name'=>str_replace([' ','/'], '-',$_category_level2->name),'id'=>$_category_level2->id])) }}">
            <h6 class="level2-item-title">{{$_category_level2->name}}</h6>
            <img src="{{ asset('storage/'.$_category_level2->image)}}" alt="@lang('home.ElectricalEquipment')|{{$_category_level2->name}}">
        </a>
        <ul>
            @foreach ($_category_level2->childs->whereIn('id',\App\Models\ShopProduct::distinct()->pluck('category_id')->toArray()) as $_category_level3)
            @if($loop->index<5)
                <li> <a href="{{urldecode(route('user.shop.category.l3.products',['name'=>str_replace([' ','/'], '-',$_category_level3->name),'id'=>$_category_level3->id])) }}"> {{$_category_level3->name}} </a></li>
            @endif
            @if($loop->index==5)
                <li><a href="{{urldecode(route('user.shop.category.l2.products',['name'=>str_replace([' ','/'], '-',$_category_level2->name),'id'=>$_category_level2->id])) }}" class="more-link">@lang('home.viewMore')</a></li>
            @endif
            @endforeach
        </ul>
    </div>
@endforeach
