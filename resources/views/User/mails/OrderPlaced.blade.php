@extends('User.mails.master_template_en')
@section('content')
    <tr>
        <td class="border"
            style="
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            color: #555559;
            font-family: Arial, sans-serif;
            font-size: 18px;
            line-height: 26px;
          ">
            <table
                style="
              font-weight: normal;
              border-collapse: collapse;
              border: 0;
              margin: 0;
              padding: 0;
              font-family: Arial, sans-serif;
              width: 100%;
            ">

                <tr>
                    <td valign="top" class="side title"
                        style="
                  border-collapse: collapse;
                  border: 0;
                  margin: 0;
                  /* padding: 10px; */
                  -webkit-text-size-adjust: none;
                  color: #555559;
                  font-family: Arial, sans-serif;
                  font-size: 18px;
                  line-height: 26px;
                  vertical-align: top;
                  background-color: white;
                  border-top: none;
                  padding-top: 0;
                ">
                        <table
                            style="
                    font-weight: normal;
                    border-collapse: collapse;
                    border: 0;
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    width: 100%;
                  ">
                            <tr>
                                <td class="top-padding"
                                    style="
                        border: 1px solid gray;
                        margin: 16px 0;
                        display: block;
                        padding: 0;
                      ">
                                </td>
                            </tr>
                            <tr>
                                <td class="text"
                                    style="
                        border-collapse: collapse;
                        border: 0;
                        margin: 0;
                        padding: 0 10px;
                        -webkit-text-size-adjust: none;
                        color: #555559;
                        font-family: Arial, sans-serif;
                        font-size: 18px;
                        line-height: 1.3;
                      ">
                                    <div class="mktEditable" id="main_text">
                                        <p
                                            style="
                            color: #23408d;
                            font-size: 30px;
                            font-weight: bold;
                            margin-bottom: 20px;
                            margin-top: 5px;
                          ">
                                            Thank you for Shopping on SouqKahraba.com!
                                        </p>
                                        <p style="margin: 0; font-size: 15px">
                                            Your order has been placed. You will be notified when
                                            the courier picks it up!
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="
                        text-align: right;
                        margin-bottom: 10px;
                        margin-top: 30px;
                        display: block;
                        padding: 0 10px;   text-align: left;
                      ">
                                    <p
                                        style="
                          margin: 0;
                          font-size: 16px;
                          color: #23408d;
                          display: inline-block;
                          font-weight: 900;
                          text-align: left;
                        ">
                                        Estimated delivery:
                                    </p>
                                    <p
                                        style="
                          margin: 0;
                          font-size: 16px;
                          color: {{ config('global.used_app_color', '') }};
                          display: inline-block;
                          font-weight: 900;
                        ">
                                        Within 5 Working Days
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="
                        background: #eeeeee;
                        font-size: 17px;
                        font-weight: bold;
                        padding: 10px;
                        border-top: 3px solid #f7cb14;
                        display: block;
                        margin-top: 0;
                      ">
                                    Your Order Details
                                    <span style="font-weight: 400; padding: 0 20px">Will be shipped Your Order
                                        Details by
                                        SouqKahraba.com</span>
                                </td>
                            </tr>
                        </table>

                        <table width="100%"
                            style="
                    border-collapse: collapse;
                    border: 0;
                    text-align: center;
                  ">

                            <tr style="border-bottom: 3px solid #eee">
                                <td style="width: 100%">
                                    <table>
                                        <!-- ROW -->
                                        @foreach ($order->items as $item)
                                            @if (!is_null($item->shopProduct))
                                                <tr style="border-bottom: 3px solid #eee;">

                                                    <td class="column-detail">
                                                        <img src="{{ asset('storage/' . $item->shopProduct->image) }}"
                                                            width="100" alt="">
                                                        <div style="display: inline-block; margin-top: 16px;">
                                                            <p style="margin : 0;font-size: 17px; color : #23408D;">
                                                                {{ $item->shopProduct->name }}
                                                            </p>
                                                            <p style="margin : 0;font-size: 17px; margin-top: 5px;">Sku Code
                                                                :
                                                                {{ $item->shopProduct->sku_code }} | Quantity Type :
                                                                {{ $item->shopProduct->QuantityType->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td width="180px" class="column-title"
                                                        style="margin : 0;font-size: 17px; color : #000;">
                                                        {{ $item->shopProduct->new_price }} EGP</td>

                                                </tr>
                                            @elseif (!is_null($item->manual_product_name))
                                                <tr style="border-bottom: 3px solid #eee;">

                                                    <td class="column-detail">
                                                        <img src="" width="100" alt="">
                                                        <div style="display: inline-block; margin-top: 16px;">
                                                            <p style="margin : 0;font-size: 17px; color : #23408D;">
                                                                {{ $item->manual_product_name }}
                                                            </p>

                                                        </div>
                                                    </td>
                                                    <td width="180px" class="column-title"
                                                        style="margin : 0;font-size: 17px; color : #000;">
                                                        {{ $item->price }} EGP</td>

                                                </tr>
                                            @endif
                                        @endforeach
                                        <!-- ROW -->
                                        <tr>
                                            <td class="column-detail"
                                                style="
                              margin: 0;
                              font-size: 17px;
                              color: #000;
                              text-align: right;
                              padding: 0 10px;
                            ">
                                                Sub Total
                                            </td>
                                            <td class="column-title" style="margin: 0; font-size: 17px; color: #000">
                                                {{ $order->subtotal }} EGP
                                            </td>
                                        </tr>
                                        <!-- ROW -->

                                        <tr>
                                            <td class="column-detail"
                                                style="
                              margin: 0;
                              font-size: 17px;
                              color: #000;
                              text-align: right;
                              padding: 0 10px;
                            ">
                                                Shipping Fees
                                            </td>
                                            <td class="column-title" style="margin: 0; font-size: 17px; color: #000">
                                                0.00 EGP
                                            </td>
                                        </tr>
                                        <!-- ROW -->

                                        <tr>
                                            <td class="column-detail"
                                                style="
                              margin: 0;
                              font-size: 17px;
                              color: #000;
                              text-align: right;
                              padding: 0 10px;
                            ">
                                                Delivery fees
                                            </td>
                                            <td class="column-title" style="margin: 0; font-size: 17px; color: #000">
                                                Will be calculated later.
                                            </td>
                                        </tr>
                                        <!-- ROW -->

                                        <tr>
                                            <td class="column-detail"
                                                style="
                              margin: 0;
                              font-size: 17px;
                              color: #000;
                              text-align: right;
                              padding: 0 10px;
                            ">
                                                Promotional Code
                                            </td>
                                            <td class="column-title" style="margin: 0; font-size: 17px; color: #000">
                                                0.00 EGP
                                            </td>
                                        </tr>
                                        <!-- ROW -->

                                        <tr>
                                            <td class="column-detail"
                                                style="
                              margin: 0;
                              font-size: 17px;
                              color: #000;
                              text-align: right;
                              padding: 0 10px;
                              font-weight: 600;
                              background-color: #dcdcdc;
                            ">
                                                Grand Total
                                            </td>
                                            <td class="column-title"
                                                style="
                              margin: 0;
                              font-size: 17px;
                              color: #000;
                              font-weight: 600;
                              background-color: #dcdcdc;
                            ">
                                                {{ $order->total }} EGP
                                            </td>
                                        </tr>
                                        <!-- ROW -->

                                        <tr>
                                            <td>
                                                Important Note: Please be ready to pay a total of
                                                <span style="font-weight: bold">{{ $order->total }} EGP</span>
                                                to the shipping courier when you receive the
                                                shipment
                                            </td>
                                        </tr>
                                        <!-- ROW -->
                                    </table>
                                </td>
                            </tr>
                        </table>

                <tr style="padding: 0 20px; display: block">
                    <td
                        style="
                      background: #eeeeee;
                      font-size: 17px;
                      font-weight: bold;
                      padding: 6px;
                      border-top: 3px solid #f7cb14;
                      display: block;
                      margin-top: 0;
                    ">
                        Your Order Details
                        <span style="font-weight: 400; padding: 0 20px">Will be shipped Your Order Details by
                            SouqKahraba.com</span>
                    </td>
                </tr>
                <tr style="padding: 20px; display: block">
                    <td
                        style="
                      font-size: 16px;
                      margin-bottom: 0;
                      margin-bottom: 5px;
                      display: block;
                    ">
                        {{ $order->address }}
                    </td>
                    <td
                        style="
                      font-size: 16px;
                      margin-bottom: 0;
                      margin-bottom: 5px;
                      display: block;
                      font-weight: bold;
                    ">
                        {{ $order->user->name }}
                    </td>
                    <td
                        style="
                      font-size: 16px;
                      margin-bottom: 0;
                      margin-bottom: 5px;
                      display: block;
                    ">
                        phone: {{ $order->user->phone }}
                    </td>
                </tr>
                <tr style="padding: 0 20px; display: block">
                    <td class="top-padding"
                        style="
                      border: 1px solid #f7cb14;
                      margin: 20px 0;
                      margin-top: 0;
                      display: block;
                      padding: 0;
                    ">
                    </td>
                </tr>
                <tr style="padding: 20px; display: block">
                    {{-- <td
                        style="
                      color: #23408d;
                      font-size: 30px;
                      font-weight: bold;
                      margin-bottom: 0;
                      margin-top: 5px;
                      display: block;
                    ">
                        Best Regards,
                    </td> --}}
                    {{-- <td
                        style="
                      color: #23408d;
                      font-size: 30px;
                      font-weight: bold;
                      margin-bottom: 20px;
                      margin-top: 5px;
                      display: block;
                    ">
                        {{ config('global.used_app_name', 'Tawredaat') }} Team
                    </td> --}}
                    {{-- <td style="display: block" colspan="4" valign="top" class="image-section"
                        style="
                      border-collapse: collapse;
                      border: 0;
                      margin: 0;
                      padding: 18px;
                      -webkit-text-size-adjust: none;
                      color: #555559;
                      font-family: Arial, sans-serif;
                      font-size: 18px;
                      line-height: 26px;
                      background-color: #f7cb14;
                      text-align: center;
                    ">
                        <a href="https://souqkahraba.com/"><img class="top-image"
                                src="{{ asset('storage/' . $site_logo) }}" style="line-height: 1; width: 300px"
                                alt="{{ config('global.used_app_name', 'Tawredaat') }}" /></a>
                    </td> --}}
                </tr>
        </td>
    </tr>
    </table>
    </td>
    </tr>
@endsection
