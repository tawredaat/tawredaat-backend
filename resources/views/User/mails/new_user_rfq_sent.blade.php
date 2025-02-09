 <?php
 $setting = App\Models\Setting::with('translations')->first();
 $rfq = 'storage/' . $setting->rfq_image;
 $rfq_alt = 'rfq';
 ?>

 @extends('User.mails.new_master_template', ['image_path' => $rfq, 'image_alt' => $rfq_alt])
 @section('content')
     <div dir="rtl" style="text-align: right;">
         <p style="text-align: right;">
             شكرا لك على اهتمامك بمنتجاتنا/ خدماتنا
             . لقد تلقينا طلبك للحصول على
             <span style="font-weight: bold;">
                 عرض أسعار (RFQ).</span>
         </p>
         <p style="text-align: right;">
             سيقوم فريقنا بمراجعة
             <span style="font-weight: bold;">
                 طلب عرض الأسعار الخاص بك
             </span>
             وإعداد
             اقتراح مفصل يلبي متطلباتك المحددة
             . سوف نضمن أن يكون عرضنا دقيقا
             وتنافسيا ويتم تسليمه في الوقت المناسب.

         </p>

         <p style="text-align: right;">
             إذا كانت لديك أي أسئلة، فإن فريق خدمة العملاء لدينا متاح لمساعدتك. لا تتردد
             <span style="font-weight: bold;"> في الاتصال بنا</span>
             على

             <span style="font-weight: bold;">
                 (01029020807)</span>
             أو

             <span style="font-weight: bold;">
                 customerservice@tawredaat.com </span>
             وسنكون سعداء بمساعدتك.
         </p>
         <p style="font-weight: bold;text-align: right;">
             شكرا لك مرة أخرى على اختيارك توريدات دوت كوم.
         </p>
     </div>
 @endsection
