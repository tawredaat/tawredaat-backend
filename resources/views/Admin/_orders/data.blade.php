@foreach ($orders as $order)
    <tr id="tr-{{$order->id}}">
        <td>
        @if($order->order_status_id==4)
            <button style="border:none;">
                <span title="Change status" style="background:{{$order->status?$order->status->color:'-'}};color:#fff;font-weight:bold;font-size:1rem" class="m-badge m-badge--wide">
                    {{ $order->status?$order->status->translate('en')->name:'--'}}
                </span>
            </button>
        @else
        <button style="border:none;cursor:pointer;" data-route="{{route('orders.change.status',$order->id)}}" class="change-status-order">
                <span title="Change status" style="background:{{$order->status?$order->status->color:'-'}};color:#fff;font-weight:bold;font-size:1rem" class="m-badge m-badge--wide">
                    {{ $order->status?$order->status->translate('en')->name:'--'}}
                </span>
            </button>
        @endif
        </td>
        <td>
            {{ $order->id}}
        </td>
        <td>
            {{ $order->user ? $order->user->id : '-'}}
        </td>
        <td>
            {{ $order->user ? $order->user->name  : '-'}}
        </td>
        <td>
            {{ $order->user ? $order->user->email : '-'}}
        </td>
        <td>
            {{ $order->user ? $order->user->phone : '-'}}
        </td>
        <td>
            {{ $order->subtotal}}
        </td>
        <td>
            {{ $order->delivery_charge}}
        </td>
        <td>
            {{ $order->total}}
        </td>
        <td>
            {{ $order->discount}}
        </td>
        <td>
            {{ $order->payment ? $order->payment->translate('en')->name : '-'}}
        </td>

        <td>
            {{ $order->created_at}}
        </td>
        <td>
            <button style="margin:5px" class="btn btn-sm btn-danger cancel-order" title="Cancel order ?"
            data-route="{{route('orders.cancel', $order->id)}}"><i class="fa fa-times"></i>
            </button>
            <a class="btn btn-sm btn-info" style="margin:5px" title="view order details"
               href="{{route('orders.show', $order->id)}}"><i class="fa fa-eye"></i>
                <span class="m-menu__link-badge">
                    <span class="m-badge m-badge--danger">
                        {{$order->items->count()}}
                    </span>
                </span>
            </a>
        </td>
    </tr>
@endforeach
