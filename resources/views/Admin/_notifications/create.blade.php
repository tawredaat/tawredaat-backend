@extends('Admin.index')
@section('notifications-active', 'm-menu__item--active m-menu__item--open')
@section('notifications-create-active', 'm-menu__item--active')
@section('page-title', 'Notifications|Create')
 @section('content')
<style type="text/css">
::-webkit-file-upload-button {
  background-color: #5867dd;
  border: 1px solid #5867dd;
  border-radius: 5px;
  color: #fff;
  padding: 5px;

}
.invalid-feedback {
    display: block;
}
</style>
      <!-- begin::Body -->
      <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
          <!-- BEGIN: Subheader -->
         <div class="m-subheader ">
            <div class="d-flex align-items-center">
               <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{$MainTitle}}
                    </h3>
                </div>
            </div>
          </div>
          <!-- END: Subheader -->
          <div class="m-content">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="m-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin::Portlet-->
                            <div class="m-portlet">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="m-portlet__head-text">
                                                {{$SubTitle}}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form-->
                            <form method="POST" id="send-notification-form" enctype="multipart/form-data" action="{{route('notifications.send')}}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                @csrf
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-3">
                                        	<label class="" style="color: red">Select Users:</label><br>
                                        	<input type="radio" checked="" id="all" name="type" value="all">
											<label for="all">General</label><br>
                                        	<input type="radio"  id="specific" name="type" value="specific">
											<label for="specific">Specific users</label><br>
                                        </div>
                                        <div class="col-lg-9">
                                            <label class="" style="color: red">Notification body:</label>
                                            <input type="text" id="notificaion-message" value="{{old('message')}}" name="message" required="" class="form-control m-input" placeholder="Enter message...">
                                           @error('message')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                    </div>
									<div style="visibility: hidden;" class="form-group m-form__group row" id="users-select">
                                        <div class="col-lg-9">
                                            <label class="" style="color: red">Select Users:</label>
   											<select multiple=""  id="selected-users" class="form-control multi m-input" name="users[]">
                                                <option value="none">--select user--</option>
   												@foreach($users as $user)
   												    <option value="{{$user->id}}">({{$user->name}}, {{$user->phone}})</option>
   												@endforeach
   											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                    <div class="m-form__actions m-form__actions--solid">
                                        <div class="row">
                                            <div class="col-lg-6">
                                            </div>
                                            <div class="col-lg-6 m--align-right">
                                                <button type="button" class="send-notification btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Portlet-->
                        </div>
                    </div>
                </div>
                </div>
            <!--End::Section-->
          </div>
        </div>
      </div>

@push('script')
<script type="text/javascript">
      $(function () {
	        $('input[type="radio"]').click(function(){
		        var inputValue = $(this).attr("value");
		        if (inputValue=='specific') {
			        $("#users-select").css("visibility", "visible");
			         $('.multi').attr('required', true);
		        }else if (inputValue=='all') {
			        $("#users-select").css("visibility", "hidden");
                    $("#selected-users").val([]).change();
		        }
		    });
	        $('.multi').select2({
	        	placeholder: " --Select users--",
			    allowClear: true
	        });
   $('.send-notification').click(function(){
        var message =$('#notificaion-message').val();
        if(!message){toastr.error("Please fill the message field."); return;};

        if($('#all').is(':checked')) {
                var user = 'All users';
                var users ='';
        }
        if ($('#specific').is(':checked')) {
                var user = 'the following users';
                var users = $("#selected-users option:selected").toArray().map(item => item.text).join();
                if (users.length==0) {toastr.error("Please select one user at least.");return;}
        }
           Swal.fire({
            title: 'Are you sure to send '+ '"'+message+'"'+' to '+user+'?'+'<br>'+users,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send!'
            }).then((result) => {
              if (result.value) {
                    $("#send-notification-form").submit();
              }
            });
        });
      });
</script>
@endpush
@endsection
 <!-- end:: Body -->

