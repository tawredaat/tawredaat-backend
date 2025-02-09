<div class="company-box-view">
  <h4>@lang('home.companies')
    <span class="ml-10"> ({{$countCompanies}})</span>
  </h4>
  <ul class="filter-group" style="margin: 0 0 10px;padding: 0;list-style: none;">
    @if($brands)
        @foreach($brands as $br)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$br->name}}
                    <a  href="#" data-brand="{{$br->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($categories)
        @foreach($categories as $cg)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$cg->name}}
                    <a  href="#" data-category="{{$cg->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($areas)
        @foreach($areas as $ar)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$ar->name}}
                    <a  href="#" data-area="{{$ar->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
    @if($types)
        @foreach($types as $tyb)
            <li class="selected-refinment" style="display: inline-block;margin-bottom: 3px;">
                <span style="border: 1px solid #e2e2e2;background-color: #fff;padding: 0px 10px;border-radius:10px;display: inline-block;">
                    {{$tyb->name}}
                    <a  href="#" data-type="{{$tyb->id}}" class="remove-filer-companies" style="display: inline;color: #888;font-size: 30px;margin: 0 5px;font-weight: bold;">×</a>
                </span>
            </li>
        @endforeach
    @endif
     </ul>
  @if(count($companies))
    <div class="grid-holder">
        @foreach($companies as $company)
            @include('User.viewCompanies')
        @endforeach
    </div>
    {{$companies->links()}}
  @else
      <h3>@lang('home.noCompanySearch')</h3>
  @endif
</div>
