
    $('#photo_upload').on('change', function(){
    	$('#uploadFile').val($(this).val());
    	var img_size = $("#photo_upload")[0].files[0].size;
    	var extension= $("#photo_upload").val().split(".").pop();
    	var msg = '';
    	if(img_size > 2097152){	msg = 'Maximum image upload size 2MB.';	}
    	if(checkExtension(extension) == false){  msg = 'Allow only extension JPEG, JPG, GIF and PNG only.'; 	}

    	if(msg != ''){
    		$('#confirm-msg-delete .modal-title').text('Error your image file');
    		$('#confirm-msg-delete .modal-body p').text(msg);
    		$('#btn-upload').addClass('disabled');
    		$('#confirm-msg-delete').modal('show');
    	}else{
    		$('#btn-upload').removeClass('disabled');
    	}
    });

    $('body').on('submit', '#photo_gallery', function(e){
    	e.preventDefault();
    	var img_file = $('#photo_upload').val();

    	if(img_file !== ''){
    		$('#btn-upload').addClass('disabled').text('Uploading ...');
			$.ajax({
				url: $(this).attr('action'), // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				dataType: 'json',
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					if(data['status'] == 'success'){
						$('#gallery-list div:first').before(data['response']);
						$('#uploadFile').val('');
					}else{
			    		$('#confirm-msg-delete .modal-title').text('Error your photo upload');
			    		$('#confirm-msg-delete .modal-body p').text(data['response']);
			    		$('#confirm-msg-delete').modal('show');
					}
				}
			});
			$('#btn-upload').removeClass('disabled').text('Upload');
    	}

    });

	$('body').on('mouseover', '.thumbnail', function(){
		var remove_btn = '<i class="remove-button"></i>';
		$(this).find('img').after(remove_btn);
	});
	$('body').on('mouseleave', '.thumbnail', function(){
		$(this).find('.remove-button').remove();
	});

	$('body').on('click', '.remove-button', function(){
		var img_id = $(this).parent().find('img').attr('id');
		$(this).parent().parent().attr('id', 'active-delete');
		$('#confirm-msg-delete .modal-body').find('p').attr('id', 'remove-'+ img_id.split('-')[1]);
		$('#confirm-msg-delete').modal('show');
	});

	$('body').on('hidden.bs.modal', '#confirm-msg-delete', function(){
		$('#active-delete').removeAttr('id');
		$('#uploadFile').val('');
    	$('#confirm-msg-delete').find('.modal-title').text('Delete Confirmation');
    	$('#confirm-msg-delete .modal-body').find('p').text('Are you sure? You want remove this photo from your gallery.');
    	$('#confirm-msg-delete .modal-footer').find('#confirm-ok').show();
    	$('#confirm-msg-delete .modal-footer').find('.btn-default').text('Cancel');
	});

	$('body').on('click', '#confirm-ok', function(){
		var did = $('#confirm-msg-delete .modal-body p').attr('id').split('-')[1];
		
		$.get('/internal-bkn/delete-photo-gallery?did='+ did, function(deleted){
			if(deleted == 'success'){
				$('#active-delete').remove();
			}
			$('#confirm-msg-delete').modal('hide');
		});
	});

    $('body').on('click', '.thumbnail img', function(){
    	var img_url = $(this).attr('src');
    	var img_html= '<img src="'+ img_url +'" />';

    	$('#view-image .modal-body').find('.img-show').html(img_html);
    	$('#view-image').modal('show');
    });

    function checkExtension(extension)
    {
    	if(extension == "jpg" || extension == "jpeg" || extension == "gif" || extension == "png" || extension == "JPG" || extension == "JPEG" || extension == "GIF" || extension == "PNG")
    	{
    		return true;
    	}else{
    		return false;
    	}
    }