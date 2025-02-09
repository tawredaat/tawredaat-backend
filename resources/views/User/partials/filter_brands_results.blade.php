<div class="brand-box-view">
  <h4>@lang('home.brands')
    <span class="ml-10"> ({{$countBrands}})</span>
  </h4>
  <ul class="filter-group" style="margin: 0 0 10px;padding: 0;list-style: none;">
    @if($categories)
    @foreach($categories as $cg)
        <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
            <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                {{$cg->name}}
                <a  href="#" data-category="{{$cg->id}}" class="remove-filer-brands" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
            </span>
        </li>
    @endforeach
    @endif
    @if($countries)
    @foreach($countries as $cr)
        <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
            <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                {{$cr->name}}
                <a  href="#" data-country="{{$cr->id}}" class="remove-filer-brands" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
            </span>
        </li>
    @endforeach
    @endif
    @if($companies)
    @foreach($companies as $cm)
        <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
            <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                {{$cm->name}}
                <a  href="#" data-company="{{$cm->id}}" class="remove-filer-brands" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
            </span>
        </li>
    @endforeach
    @endif
     </ul>
     @if(count($brands))
        <div class="grid-holder">
            @foreach($brands as $brand)
            @include('User.viewBrands')
            @endforeach
        </div>
        <br>
        {{$brands->appends(Request::all())->links()}}
        @else
        <h3>@lang('home.noBrandSearch')
        </h3>
    @endif
</div>
