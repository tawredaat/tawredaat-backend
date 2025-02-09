<script type="text/javascript">
$(document).ready(function() {
	//make brands have select2
	$("#brands").select2();
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	//get level one category based on selected brand 
	$('#brands').on('change',function(e){
		  $('#step1').prop("disabled", false);
	      var _route = "{!! route('company.brand.categories.levels1')!!}";
	      var brandID = this.value;
	      $.ajax({
	          url:_route, 
	          method: 'POST',
	          data: {_token: CSRF_TOKEN, brandID: brandID},
	          dataType: 'JSON',
	          beforeSend:function(){
	            $('#levels1').empty();
	          },
	          success: function (data) { 
	          		$("#Check_levels1").removeAttr("disabled");
		            for (i=0; i < data.length; i++){
			            if(data[i] !== null) {
			                optionText  = data[i]['name']; 
			                optionValue = data[i]['id']; 
			                var input   = '<div style="margin: 5px 0;"><input type="checkbox" name="level1_id[]" class="levels_1" value="'+optionValue+'">'+optionText+'</div>';
			                 	 $('#levels1').append(input); 
		                }
		            }
	          }
	          ,error:function(data){
		      		$("#Check_levels1").attr("disabled", true);
		        	$('#step2').prop("disabled", true);
			       	input = '<span>This brand has no categories</span>'
			        $('#levels1').append(input);
	          }
	      }); //end of select brand request
	});
	//end of select brand condidtion
	///======================================================================================================
	//Selecte all level one categories
	//check all levels1
	$("#Check_levels1").click(function(){
		if($(this).prop("checked") == true){
			var l1CategoriesIDs = [];
		    var _route = "{!! route('company.level1.categories.levels2')!!}";
		    var brand  = $("#brands").val();
			$('#step2').prop("disabled", false);
		    $('#levels1 :input:checkbox').not(this).prop('checked', this.checked);
		    $("#levels1 :input:checkbox").each(function() {
		    	l1CategoriesIDs.push(this.value);
		    });
	      	$.ajax({
	          url:_route, 
	          method: 'POST',
	          data: {_token: CSRF_TOKEN, l1CategoriesIDs: l1CategoriesIDs, brand:brand},
	          dataType: 'JSON',
	          beforeSend:function(){
	            $('#levels2').empty();
	          },
	          success: function (data) { 
	            for (i=0; i < data.length; i++){
			       if(data[i] !== null) {
		                optionText = data[i]['name']; 
		                optionValue = data[i]['id']; 
		               var input   = '<div style="margin: 5px 0;" id="level1id'+optionValue+'"><input type="checkbox"  name="level2_id[]" class="levels_2" value="'+optionValue+'">'+optionText+'</div>';
			                $('#levels2').append(input); 
		            }
	            }
	          }
	          ,error:function(data){
	            $('#levels2').empty();
	          }
	      	}); 
		}else{
			//uncheck all level1 category
			$('#levels1 :input:checkbox').not(this).prop('checked',false);
			$('#levels2').empty();
		}
	}); //end of select all level1 category

	//select and unselect singel level 1 category
	$(document).on('click', '.levels_1', function(e) {
	  $('#step2').prop("disabled", false);
      var _route = "{!! route('company.level1.categories.levels2')!!}";
      var brand  = $("#brands").val();
      l1CategoriesIDs = [];
      l1CategoriesIDs.push(this.value);
      //uncheck checkbox levels1 categories
	  	if($(this).prop("checked") == false){
		      $.ajax({
		          url:_route, 
		          method: 'POST',
		          data: {_token: CSRF_TOKEN, l1CategoriesIDs: l1CategoriesIDs, brand: brand},
		          dataType: 'JSON',
		          success: function (data) { 
		            for (i=0; i < data.length; i++){
			            if(data[i] !== null) {
				            optionValue = data[i]['id']; 
			    	        $("#level1id"+optionValue).remove(); 
			            }
		        	}
		          }
		          ,error:function(data){
		            $('#levels2').empty();
		          }
		      }); 
		 	return;
      }
      $.ajax({
          url:_route, 
          method: 'POST',
		          data: {_token: CSRF_TOKEN, l1CategoriesIDs: l1CategoriesIDs, brand: brand},
          dataType: 'JSON',
          success: function (data) { 
            for (i=0; i < data.length; i++){
            	if(data[i] !== null) {
	                optionText = data[i]['name']; 
	                optionValue = data[i]['id']; 
	               var input   = '<div style="margin: 5px 0;" id="level1id'+optionValue+'"><input type="checkbox"  name="level2_id[]" class="levels_2" value="'+optionValue+'">'+optionText+'</div>';
		                $('#levels2').append(input); 
	            }
            }
          }
          ,error:function(data){
            $('#levels2').empty();
          }
      }); 
    });
	///======================================================================================================
	//check all levels2
	$("#Check_levels2").click(function(){
	    var _route = "{!! route('company.level2.categories.levels3')!!}";
      	var brand  = $("#brands").val();
      	var l2CategoriesIDs = [];
	if($(this).prop("checked") == true){
		$('#step3').prop("disabled", false);
	    $('#levels2 :input:checkbox').not(this).prop('checked', this.checked);
	    $("#levels2 :input:checkbox").each(function() {
	    	l2CategoriesIDs.push(this.value);
	    });
     	 $.ajax({
          url:_route, 
          method: 'POST',
          data: {_token: CSRF_TOKEN, l2CategoriesIDs: l2CategoriesIDs, brand:brand},
          dataType: 'JSON',
          beforeSend:function(){
	            $('#levels3').empty();
	      },
          success: function (data) { 
            for (i=0; i < data.length; i++){
				 if(data[i] !== null) {
	                optionText = data[i]['name']; 
	                optionValue = data[i]['id']; 
	               var input   = '<div style="margin: 5px 0;" id="level2id'+optionValue+'"><input type="checkbox" name="level3_id[]" class="levels_3" value="'+optionValue+'">'+optionText+'</div>';
	                $('#levels3').append(input); 
	            }
            }
          }
          ,error:function(data){
            $('#levels3').empty();
          }
      }); 
	}else{
		$('#levels2 :input:checkbox').not(this).prop('checked',false);
		$('#levels3').empty();
	}
});
 $(document).on('click', '.levels_2', function(e) {
	  $('#step3').prop("disabled", false);
      var _route = "{!! route('company.level2.categories.levels3')!!}";
      var brand  = $("#brands").val();
      l2CategoriesIDs = [];
      l2CategoriesIDs.push(this.value);
      if($(this).prop("checked") == false){
		      $.ajax({
		          url:_route, 
		          method: 'POST',
		          data: {_token: CSRF_TOKEN, l2CategoriesIDs: l2CategoriesIDs, brand:brand},
		          dataType: 'JSON',
		          success: function (data) { 
		            for (i=0; i < data.length; i++){
						 if(data[i] !== null) {
		    	            optionValue = data[i]['id']; 
			    	        $("#level2id"+optionValue).remove(); 
			           }
		            }

		          }
		          ,error:function(data){
		            $('#levels2').empty();
		          }
		      }); 
		 	return;
         }
	      $.ajax({
	          url:_route, 
	          method: 'POST',
		          data: {_token: CSRF_TOKEN, l2CategoriesIDs: l2CategoriesIDs, brand:brand},
	          dataType: 'JSON',
	          success: function (data) { 
	            for (i=0; i < data.length; i++){
					if(data[i] !== null) {
		                optionText = data[i]['name']; 
		                optionValue = data[i]['id']; 
		               var input   = '<div style="margin: 5px 0;" id="level2id'+optionValue+'"><input type="checkbox" name="level3_id" class="levels_3" value="'+optionValue+'">'+optionText+'</div>';
		                $('#levels3').append(input); 
	            	}
	            }
	          }
	          ,error:function(data){
	            $('#levels3').empty();
	          }
	      }); 
    });
 ///==========================================================================================
 //check all levels2
$("#Check_levels3").click(function(){
    var _route = "{!! route('company.categories.products')!!}";
  	var brand  = $("#brands").val();
  	l3CategoriesIDs = [];
	if($(this).prop("checked") == true){
			$('#step4').prop("disabled", false);
		    $('#levels3 :input:checkbox').not(this).prop('checked', this.checked);
		    $("#levels3 :input:checkbox").each(function() {
			     l3CategoriesIDs.push(this.value);
		    });
	      	$.ajax({
	          url:_route, 
	          method: 'POST',
		      data: {_token: CSRF_TOKEN, l3CategoriesIDs: l3CategoriesIDs, brand:brand},
	          dataType: 'JSON',
	          beforeSend:function(){
	            	$('#products').empty();
	      	  },
	          success: function (data) { 
	          	if (data.length==0) {
	          		$('#products').append('<span>There are no products avilable.</span>'); 
	          	}
	            for (i=0; i < data.length; i++){
					if(data[i] !== null) {
		                optionText = data[i]['name']; 
		                optionValue = data[i]['id']; 
		                var input   = '<div style="margin: 5px 0;" id="productid'+optionValue+'"><input type="checkbox"  name="products[]" class="products" value="'+optionValue+'">'+optionText+'</div>';
		                $('#products').append(input); 
		            }
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
	}else{
		$('#levels3 :input:checkbox').not(this).prop('checked',false);
		$('#products').empty();
	}
});


 $(document).on('click', '.levels_3', function(e) {
	  $('#step4').prop("disabled", false);
      var _route = "{!! route('company.categories.products')!!}";
      var brand  = $("#brands").val();
      l3CategoriesIDs = [];
      l3CategoriesIDs.push(this.value);
      if($(this).prop("checked") == false){
		      $.ajax({
		          url:_route, 
		          method: 'POST',
		          data: {_token: CSRF_TOKEN, l3CategoriesIDs: l3CategoriesIDs, brand:brand},
		          dataType: 'JSON',
		          success: function (data) { 
		            for (i=0; i < data.length; i++){
						if(data[i] !== null) {
			                optionValue = data[i]['id']; 
				            $("#productid"+optionValue).remove(); 
			           	}
		            }

		          }
		          ,error:function(data){
		            $('#products').empty();
		          }
		      }); 
		 	return;
      }
      $.ajax({
          url:_route, 
          method: 'POST',
		  data: {_token: CSRF_TOKEN, l3CategoriesIDs: l3CategoriesIDs, brand:brand},
          dataType: 'JSON',
          success: function (data) { 
          		if (data.length==0 && $('#products').html() == '') {
	          		$('#products').append('<span>There are no products avilable.</span>'); 
	          	}
            for (i=0; i < data.length; i++){
				if(data[i] !== null) {
	                optionText = data[i]['name']; 
	                optionValue = data[i]['id']; 
	                var input   = '<div style="margin: 5px 0;" id="productid'+optionValue+'"><input type="checkbox"  name="products[]" class="products" value="'+optionValue+'">'+optionText+'</div>';
	                $('#products').append(input); 
            	}
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
//===============================================================================
 //check all products
$("#Check_products").click(function(){
	if($(this).prop("checked") == true){
    	$('#products :input:checkbox').not(this).prop('checked', this.checked);
	}else{
		$('#products :input:checkbox').not(this).prop('checked',false);
	}
});
//===============================================================================
 //script to allow next buttons work

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
});//end of script

</script>