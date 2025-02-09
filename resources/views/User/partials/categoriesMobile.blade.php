<li class="nav-item dropdown categories-btn-responsive">
    <a
         class="nav-link nav-link-collapse collapsed"
         href="#"
         id="hasSubItemsResp"
         data-toggle="collapse"
         data-target="#navAccordion2"
         aria-controls="navAccordion2"
         aria-expanded="false"
         >
    @lang('home.categories')
  </a>
  <ul id="navAccordion2" class="nav-list-holder nav-level collapse">
    @foreach($categories as $category)
    <li class="nav-item">
      <a
         class="nav-link nav-link-collapse collapsed"
         href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$category->translate('en')->name),'id'=>$category->id])) }}"
         id="hasSubItems"
         data-toggle="collapse"
         data-target="#collapseSubItems-{{$category->id}}-22"
         aria-controls="collapseSubItems-{{$category->id}}-22"
         aria-expanded="false"
         >{{$category->name}}
      </a>
      <ul
          class="nav-second-level collapse"
          id="collapseSubItems-{{$category->id}}-22"
          data-parent="#navAccordion"
          >
        @foreach($category->childs as $l2category)
        <li class="nav-item">
          <a class="nav-link nav-link-collapse collapsed"
             href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$l2category->translate('en')->name),'id'=>$l2category->id])) }}"
             id="hasSubItems"
             data-toggle="collapse"
             data-target="#collapseSubItems-{{$l2category->id}}-222"
             aria-controls="collapseSubItems-{{$l2category->id}}-222"
             aria-expanded="false" href="#">
            <span class="nav-link-text">{{ $l2category->name}}
            </span>
          </a>
          <ul
              class="nav-second-level collapse"
              id="collapseSubItems-{{$l2category->id}}-222"
              data-parent="#navAccordion2">
            @foreach($l2category->childs as $l3category)
            <li class="nav-item">
              <a class="nav-link" href="{{urldecode(route('user.filter-by-category1',['name'=>str_replace([' ','/'], '-',$l3category->translate('en')->name),'id'=>$l3category->id])) }}">
                <span class="nav-link-text"> - {{$l3category->name}}
                </span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </li>
    @endforeach
  </ul>
</li>
