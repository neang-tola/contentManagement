
    $('#categoryImage').on('change', function(){
    	$('#uploadFile').val($(this).val());

        if($(this).val() != ''){
        	var img_size = $("#categoryImage")[0].files[0].size;
        	var extension= $("#categoryImage").val().split(".").pop();
        	var msg = '';
        	if(img_size > 2097152){	msg = 'Maximum image upload size 2MB.';	}
        	if(checkExtension(extension) == false){  msg = 'Allow only extension JPEG, JPG, GIF and PNG only.'; 	}

        	if(msg != ''){
                $('#categoryImage').val('');
        		$('#uploadFile').val('');
                $('#modal-message .modal-body p').text(msg);
        		$('#modal-message').modal('show');
        	}
        }
    });

  $('#categoryTitle').on('blur', function(){
    var title_val = $(this).val();

    if(title_val == ''){
      $('#categoryTitle').css('border', '1px solid red');
      $('#err_title').text('Category Title is required field.');
    }else{
      $('#categoryTitle').css('border', '1px solid #c7c7cc');
      $('#err_title').text('');
    }
  });

  $('#categoryOrder').on('blur', function(){
    var order_val = $(this).val();

    if($.isNumeric(order_val) == false){
      $('#categoryOrder').css('border', '1px solid red');
      $('#err_order').text('Category Order is the field required and allow number only');
    }else{
      $('#categoryOrder').css('border', '1px solid #c7c7cc');
      $('#err_order').text('');
    }
  });

	function isValidate_form_category()
	{
		var status    = true;

		if($('#categoryTitle').val() == ''){
		  $('#categoryTitle').css('border', '1px solid red');
		  $('#err_title').text('Category Title is required field.');
		  status = false;
		} 

		if($('#categoryDes').val() == ''){
		  $('#err_des').text('Description is required field.');
		  status = false;
		}

        if($.isNumeric($('#categoryOrder').val()) == false){
          $('#categoryOrder').css('border', '1px solid red');
          $('#err_title').text('Category Order is the field required and allow number only');
          status = false;
        }

		return status;
	}
  
	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#blah').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}  
	
    function checkExtension(extension)
    {
    	if(extension == "jpg" || extension == "jpeg" || extension == "gif" || extension == "png" || extension == "JPG" || extension == "JPEG" || extension == "GIF" || extension == "PNG")
    	{
    		return true;
    	}else{
    		return false;
    	}
    }