<ul class="megamenu wwwww">
  @foreach($categories as $category)
  <li>
    <a href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$category->name),'id'=>$category->id])) }}">
      <span>{{$category->name}}
      </span>
    </a>
    <div>
      @foreach($category->childs as $l2Category)
      <div >
        <a href="{{ urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$l2Category->name),'id'=>$l2Category->id])) }}">
          <p class="headline-title">{{$l2Category->name}}
          </p> 
        </a>
        <ul>   
          @foreach($l2Category->childs as $l3Category)
          <li>
            <a href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$l3Category->name),'id'=>$l3Category->id])) }}">{{$l3Category->name}}
            </a>
          </li>
          @endforeach
          <li class="more" style="display: none;">
            <a href="">@lang('home.viewMore')
            </a>
          </li>
        </ul>
      </div>
      @endforeach
    </div>
  </li>
  @endforeach
</ul>
