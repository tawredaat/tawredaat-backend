@if (!is_null($item->shopProduct))
    {{-- <img src="{{ asset('storage/' . $item->shopProduct->image) }}"
        style="display:inline;height:150px;width: 100px;float:right;padding:1px;"> --}}
    <p style="font-weight:bold; text-align: right;">
       الاسم  : {{ $item->shopProduct->name }}
    </p>
    <p style=" font-size:15px;text-align: right;">
        الكود  : {{ $item->shopProduct->sku_code }}
     </p>
    <p style=" font-size:15px;text-align: right;">
        الماركه :  {{ $item->shopProduct->brand->translate('ar')->name }}
    </p>
    @if($item->bundel_id)
    <p style=" font-size:15px;text-align: right;">
        رقم الباقة :  {{ $item->bundel_id }}
    </p>
    @endif
    <p style="font-size:15px;text-align: right;">
        السعر : 
        @if (is_null($item->shopProduct->new_price))
            <span style="font-size:15px;text-align: right;">
                {{ $item->shopProduct->old_price }}
            </span>
        @else
            <span style="font-size:15px; text-decoration: line-through;text-align: right;">
                {{ $item->shopProduct->old_price }}
            </span>
            <span
                style="text-align: right;font-size:15px;color:{{ config('global.used_app_color', '') }};">
                {{ $item->shopProduct->new_price }}
            </span>
        @endif
    </p>

    <p style="font-size:15px;text-align: right;">الكمية:
        {{ $item->quantity }}</p>
    <?php
    $price = $item->shopProduct->new_price ?? $item->shopProduct->old_price;
    ?>
    <p style="font-size:15px;text-align: right;">الاجمالي:
        {{ $item->quantity * $price }}
    </p>
@elseif (!is_null($item->manual_product_name))
    <p style="text-align: right; font-weight:bold;">
       الاسم : {{ $item->manual_product_name }}
    </p>
    <p style="text-align: right;font-size:15px;">
       السعر : {{ $item->price }}
    </p>
    <p style="text-align: right;font-size:15px;">الكمية:
        {{ $item->quantity }}</p>
    <p style="text-align: right;font-size:15px;">الاجمالي:
        {{ $item->quantity * $item->price }}
    </p>
@endif
