<script type="text/javascript">
	$("#brands").select2();
 $(document).ready(function() {
 	 	// $('#step5').click(function() {
	   //    checked = $("#productid input[type=checkbox]:checked").length;
	   //    if(!checked) {
	   //      toastr.error('You must check at least one product.')
	   //      // alert('error');
	   //      return false;
	   //    }
	   //    else
	   //    	return true;
	   //  });
		var count = 0; // To Count Blank Fields
		/*------------ Validation Function-----------------*/
		$(".submit_btn").click(function(event) {
		var radio_check = $('.rad'); // Fetching Radio Button By Class Name
		var input_field = $('.text_field'); // Fetching All Inputs With Same Class Name text_field & An HTML Tag textarea
		var text_area = $('textarea');
		// Validating Radio Button
		if (radio_check[0].checked == false && radio_check[1].checked == false) {
		var y = 0;
		} else {
		var y = 1;
		}
		// For Loop To Count Blank Inputs
		for (var i = input_field.length; i > count; i--) {
		if (input_field[i - 1].value == '' || text_area.value == '') {
		count = count + 1;
		} else {
		count = 0;
		}
		}
		// Notifying Validation
		if (count != 0 || y == 0) {
			alert("*All Fields are mandatory*");
		event.preventDefault();
		} else {
		return true;
		}
		});
		/*---------------------------------------------------------*/
		$(".next_btn").click(function() { // Function Runs On NEXT Button Click
		$(this).parent().next().fadeIn('slow');
		$(this).parent().css({
		'display': 'none'
		});
		// Adding Class Active To Show Steps Forward;
		$('.active').next().addClass('active');
		});
		$(".pre_btn").click(function() { // Function Runs On PREVIOUS Button Click
		$(this).parent().prev().fadeIn('slow');
		$(this).parent().css({
		'display': 'none'
		});
		// Removing Class Active To Show Steps Backward;
		$('.active:last').removeClass('active');
		});
		// Validating All Input And Textarea Fields
		$(".submit_btn").click(function(e) {
		if ($('input').val() == "" || $('textarea').val() == "") {
		alert("*All Fields are mandatory*");
		return false;
		} else {
		return true;
		}
		});
   $('#brands').on('change',function(e){
	  $('#step1').prop("disabled", false);
      var _route = "{!! route('company.categories.levels1')!!}";
      var parent = this.value;
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
          url:_route, 
          method: 'POST',
          data: {_token: CSRF_TOKEN, id: parent},
          dataType: 'JSON',
          beforeSend:function(){
            $('#levels1').empty();
          },
          success: function (data) { 
          		$("#Check_levels1").removeAttr("disabled");
	            for (i=0; i < data.length; i++){
	                optionText  = data[i]['name']; 
	                optionValue = data[i]['id']; 
	                var input   = '<div style="margin: 5px 0;"><input type="checkbox" name="level1_id[]" class="levels_1" value="'+optionValue+'">'+optionText+'</div>';
	                 // if($(input).prop("checked") == true){
	                 	 $('#levels1').append(input); 
	                 // }
	            }

          }
          ,error:function(data){
	      		$("#Check_levels1").attr("disabled", true);
	        	$('#step2').prop("disabled", true);
		       	input = '<span>This brand has no categories</span>'
		        $('#levels1').append(input);
          }
      }); 
    });

    $(document).on('click', '.levels_1', function(e) {
	  $('#step2').prop("disabled", false);
      var _route = "{!! route('company.categories.levels2')!!}";
      var parent = this.value;
      var brand  = $("#brands").val();
      //uncheck checkbox levels1 categories
	  if($(this).prop("checked") == false){
		      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		      $.ajax({
		          url:_route, 
		          method: 'POST',
		          data: {_token: CSRF_TOKEN, id: parent, brand: brand},
		          dataType: 'JSON',
		          success: function (data) { 
		            for (i=0; i < data.length; i++){
		                optionValue = data[i]['id']; 
			            $("#level1id"+optionValue).remove(); 
		            }

		          }
		          ,error:function(data){
		            $('#levels2').empty();
		          }
		      }); 
		 	return;
         }
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
          url:_route, 
          method: 'POST',
          data: {_token: CSRF_TOKEN, id: parent, brand: brand},
          dataType: 'JSON',
          success: function (data) { 
            for (i=0; i < data.length; i++){
                optionText = data[i]['name']; 
                optionValue = data[i]['id']; 
               var input   = '<div style="margin: 5px 0;" id="level1id'+optionValue+'"><input type="checkbox"  name="level2_id[]" class="levels_2" value="'+optionValue+'">'+optionText+'</div>';
	                $('#levels2').append(input); 
            }
          }
          ,error:function(data){
            $('#levels2').empty();
          }
      }); 
    });

 $(document).on('click', '.levels_2', function(e) {
	  $('#step3').prop("disabled", false);
      var _route = "{!! route('company.categories.levels3')!!}";
      var parent = this.value;
      var brand  = $("#brands").val();
      if($(this).prop("checked") == false){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		      $.ajax({
		          url:_route, 
		          method: 'POST',
		          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
		          dataType: 'JSON',
		          success: function (data) { 
		            for (i=0; i < data.length; i++){
		                optionValue = data[i]['id']; 
			            $("#level2id"+optionValue).remove(); 
		            }

		          }
		          ,error:function(data){
		            $('#levels2').empty();
		          }
		      }); 
		 	return;
         }
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
          url:_route, 
          method: 'POST',
          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
          dataType: 'JSON',
          success: function (data) { 
            for (i=0; i < data.length; i++){
                optionText = data[i]['name']; 
                optionValue = data[i]['id']; 
               var input   = '<div style="margin: 5px 0;" id="level2id'+optionValue+'"><input type="checkbox" name="level3_id[]" class="levels_3" value="'+optionValue+'">'+optionText+'</div>';
                $('#levels3').append(input); 
            }
          }
          ,error:function(data){
            $('#levels3').empty();
          }
      }); 
    });

 $(document).on('click', '.levels_3', function(e) {
	  $('#step4').prop("disabled", false);
      var _route = "{!! route('company.categories.products')!!}";
      var parent = this.value;
            var brand  = $("#brands").val();
      if($(this).prop("checked") == false){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		      $.ajax({
		          url:_route, 
		          method: 'POST',
		          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
		          dataType: 'JSON',
		          success: function (data) { 
		            for (i=0; i < data.length; i++){
		                optionValue = data[i]['id']; 
			            $("#productid"+optionValue).remove(); 
		            }

		          }
		          ,error:function(data){
		            $('#products').empty();
		          }
		      }); 
		 	return;
      }
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
          url:_route, 
          method: 'POST',
          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
          dataType: 'JSON',
          success: function (data) { 
            for (i=0; i < data.length; i++){
                optionText = data[i]['name']; 
                optionValue = data[i]['id']; 
                var input   = '<div style="margin: 5px 0;" id="productid'+optionValue+'"><input type="checkbox"  name="products[]" class="products" value="'+optionValue+'">'+optionText+'</div>';
                $('#products').append(input); 
            }
        	// if (i==0) {
        	// 	$('#products').empty();
         //    	$('#products').append('<h4>There are no proudcts avilable in selected brand</h4>');
         //    }
          }
          ,error:function(data){
            $('#products').empty();
          }
      }); 
    });
});

//check all levels1
$("#Check_levels1").click(function(){
	if($(this).prop("checked") == true){
		$('#step2').prop("disabled", false);
	    $('#levels1 :input:checkbox').not(this).prop('checked', this.checked);
	    $("#levels1 :input:checkbox").each(function() {
	        var _route = "{!! route('company.categories.levels2')!!}";
	      	var parent = this.value;
	      	var brand  = $("#brands").val();
	 		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	      	$.ajax({
	          url:_route, 
	          method: 'POST',
	          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
	          dataType: 'JSON',
	          success: function (data) { 
	            for (i=0; i < data.length; i++){
	                optionText = data[i]['name']; 
	                optionValue = data[i]['id']; 
	               var input   = '<div style="margin: 5px 0;" id="level1id'+optionValue+'"><input type="checkbox"  name="level2_id[]" class="levels_2" value="'+optionValue+'">'+optionText+'</div>';
		                $('#levels2').append(input); 
	            }
	          }
	          ,error:function(data){
	            $('#levels2').empty();
	          }
	      	}); 
	    });
	}else{
		$('#levels1 :input:checkbox').not(this).prop('checked',false);
		$('#levels2').empty();
	}
});


//check all levels2
$("#Check_levels2").click(function(){
	if($(this).prop("checked") == true){
		$('#step3').prop("disabled", false);
	    $('#levels2 :input:checkbox').not(this).prop('checked', this.checked);
	    $("#levels2 :input:checkbox").each(function() {
	        var _route = "{!! route('company.categories.levels3')!!}";
	      	var parent = this.value;
	      	 var brand  = $("#brands").val();
	     	 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	     	 $.ajax({
	          url:_route, 
	          method: 'POST',
	          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
	          dataType: 'JSON',
	          success: function (data) { 
	            for (i=0; i < data.length; i++){
	                optionText = data[i]['name']; 
	                optionValue = data[i]['id']; 
	               var input   = '<div style="margin: 5px 0;" id="level2id'+optionValue+'"><input type="checkbox" name="level3_id[]" class="levels_3" value="'+optionValue+'">'+optionText+'</div>';
	                $('#levels3').append(input); 
	            }
	          }
	          ,error:function(data){
	            $('#levels3').empty();
	          }
	      }); 
	    });
	}else{
		$('#levels2 :input:checkbox').not(this).prop('checked',false);
		$('#levels3').empty();
	}
});


//check all levels2
$("#Check_levels3").click(function(){
	if($(this).prop("checked") == true){
		$('#step4').prop("disabled", false);
	    $('#levels3 :input:checkbox').not(this).prop('checked', this.checked);
	    $("#levels3 :input:checkbox").each(function() {
	        var _route = "{!! route('company.categories.products')!!}";
	      	var parent = this.value;
	      	// alert(parent);
	      	 var brand  = $("#brands").val();
	     	 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	      	$.ajax({
	          url:_route, 
	          method: 'POST',
	          data: {_token: CSRF_TOKEN, id: parent, brand:brand},
	          dataType: 'JSON',
	          success: function (data) { 
	            for (i=0; i < data.length; i++){
	                optionText = data[i]['name']; 
	                optionValue = data[i]['id']; 
	                var input   = '<div style="margin: 5px 0;" id="productid'+optionValue+'"><input type="checkbox"  name="products[]" class="products" value="'+optionValue+'">'+optionText+'</div>';
	                $('#products').append(input); 
	            }
	            // if (i==0) {
	            // 	$('#products').empty();
	            // 	$('#products').append('<h4>There are no proudcts avilable in selected brand</h4>');
	            // }
	          }
	          ,error:function(data){
	            $('#products').empty();
	          }
	      }); 
	    });
	}else{
		$('#levels3 :input:checkbox').not(this).prop('checked',false);
		$('#products').empty();
	}
});

$("#Check_products").click(function(){
	if($(this).prop("checked") == true){
    	$('#products :input:checkbox').not(this).prop('checked', this.checked);
	}else{
		$('#products :input:checkbox').not(this).prop('checked',false);
	}
});

</script>