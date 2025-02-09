@foreach($brands as $brand)
<div class="modal fade" id="rankPoints{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Rank Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('rank.point.brand.update')}}"  id="RankPoint{{$brand->id}}" class="CompanyRankPoint" method="POST">@csrf
                    <input type="hidden"  name="id" value="{{$brand->id}}">
                    <input type="number" value="{{old('rank')?old('rank'):$brand->rank}}" min="0" step="0.1" placeholder="Rank Point.." name="rank" class="form-control">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="RankPoint{{$brand->id}}" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endforeach
