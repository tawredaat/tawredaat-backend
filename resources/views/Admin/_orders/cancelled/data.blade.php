@foreach ($orders as $order)
    <tr id="tr-{{$order->id}}">
        <td>
            {{ $order->cancelled_by ? $order->canceledBy->name : '-'}}
        </td>
        <td>
            {{ $order->cancelled_at}}
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
            <a class="btn btn-sm btn-info" style="margin:5px" title="view order details"
               href="{{route('orders.cancelled.show', $order->id)}}"><i class="fa fa-eye"></i>
                <span class="m-menu__link-badge">
                    <span class="m-badge m-badge--danger">
                        {{$order->items->count()}}
                    </span>
                </span>
            </a>
        </td>
    </tr>
@endforeach
