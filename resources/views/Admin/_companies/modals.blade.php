@foreach($companies as $company)
<div class="modal fade" id="exampleModalCenter{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change Company Pssword</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="changeCompanyPass{{$company->id}}" class="changeCompanyPass" method="POST">@csrf
                    <input type="hidden"  name="id" value="{{$company->id}}">
                    <input type="password" placeholder="Password.." name="password" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                    <button type="submit" form="changeCompanyPass{{$company->id}}" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rankPoints{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Rank Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('rank.point.company.update')}}"  id="RankPoint{{$company->id}}" class="CompanyRankPoint" method="POST">@csrf
                    <input type="hidden"  name="id" value="{{$company->id}}">
                    <input type="number" value="{{old('rank')?old('rank'):$company->rank}}" min="0" step="0.1" placeholder="Rank Point.." name="rank" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                    <button type="submit" form="RankPoint{{$company->id}}" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach