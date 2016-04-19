
    $('#slide_upload').on('change', function(){
    	$('#uploadFile').val($(this).val());
    	var img_size = $("#slide_upload")[0].files[0].size;
    	var extension= $("#slide_upload").val().split(".").pop();
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

    $('body').on('click', '.images img', function(){
    	var img_html = $(this).parent().html();
    	$('#view-image .modal-body').find('.img-show').html(img_html);
    	$('#view-image').modal('show');
    });

    $('body').on('click', '.status-s', function(){
       var val_id = $(this).attr('id');
	   var status_id = val_id.split('-')[2];
	   var slide_id  = val_id.split('-')[1];
	   
	   $.get('/internal-bkn/change-status-slideshow?sid='+ slide_id +'-'+ status_id, function(result){
		   if(result == 'success'){
			   if(status_id == 0){
				   $('#'+ val_id).find('i').attr('class', 'inactive-button');
				   $('#'+ val_id).attr('id', 'status-'+ slide_id +'-1');
			   }else{
				   $('#'+ val_id).find('i').attr('class', 'active-button');
				   $('#'+ val_id).attr('id', 'status-'+ slide_id +'-0');
			   }
		   }
	   });
    });
	
	$('body').on('click', '.del-button', function(){
		$(this).parent().parent().attr('id', 'active-row-delete');
		var del_id = $(this).attr('id').split('-')[1];

		$('#confirm-msg-delete .modal-body p').attr('id', 'did-'+ del_id);
		$('#confirm-msg-delete').modal('show');
	});
	
	$('body').on('hidden.bs.modal', '#confirm-msg-delete', function(){
		$('#active-row-delete').removeAttr('id');
		$('#uploadFile').val('');
    	$('#confirm-msg-delete').find('.modal-title').text('Delete Confirmation');
    	$('#confirm-msg-delete .modal-body').find('p').text('Are you sure? You want remove this image from slideshow list.');
    	$('#confirm-msg-delete .modal-footer').find('#confirm-ok').show();
    	$('#confirm-msg-delete .modal-footer').find('.btn-default').text('Cancel');
	});

	$('body').on('click', '#confirm-ok', function(){
		var did = $('#confirm-msg-delete .modal-body p').attr('id').split('-')[1];
		
		$.get('/internal-bkn/delete-slideshow?did='+ did, function(deleted){
			if(deleted == 'success'){
				$('#active-row-delete').remove();
			}
			$('#confirm-msg-delete').modal('hide');
		});
	});

	$('body').on('click', 'ul.pagination a', function(ev){
		ev.preventDefault();
		var active_val = $(this).html();
		var pagin_ul   = '';
		var pagin_li   = '';
		var total_li   = $('ul.pagination li').length - 2;
		var first_li   = '<li><a href="/internal-bkn/loading-slideshow-list?page=1">«</a></li>';
		var last_li    = '<li><a href="/internal-bkn/loading-slideshow-list?page='+ total_li +'" rel="next">»</a></li>';

		var page 	   = $(this).attr('href').split('page=')[1];

		$('#result_output tbody').css('opacity', '0.6');
		$('.table-responsive .loading').fadeIn('fast');

		if(active_val == '«'){
			first_li  =  '<li class="active"><span>«</span></li>';
		}
		if(active_val == '»'){
			last_li   =  '<li class="active"><span>»</span></li>';
		}
			
		if(total_li > 0){
			for(var k=1; k<=total_li; k++){
				if($.isNumeric(active_val) == true){
					if(parseInt(active_val) == 1){
						first_li = '<li class="disabled"><span>«</span></li>';
					}

					if(parseInt(active_val) == k){
						pagin_li += '<li class="active"><span>'+ k +'</span></li>';
					}else{
						pagin_li += '<li><a href="/internal-bkn/loading-slideshow-list?page='+ k +'">'+ k +'</a></li>';
					}
				}else{
					pagin_li += '<li><a href="/internal-bkn/loading-slideshow-list?page='+ k +'">'+ k +'</a></li>';
				}

			}
		} // End total_li
			
		if(pagin_li != ""){
			pagin_ul = '<ul class="pagination">'+ first_li + pagin_li + last_li + '</ul>';
		}

		$.get('/internal-bkn/loading-slideshow-list?page='+ page, function(data){
			if(data != ""){
		
				$('#result_output tbody').html(data);
				$('#list-pagin').html(pagin_ul);
					
			}
			$('.table-responsive .loading').fadeOut('fast');
			$('#result_output tbody').css('opacity', '1');
		});
	});

	$('body').on('click', '.order', function(){
		$('.sequense').remove();
		$('.order').show();
		$(this).hide();

		var control = myControl($(this).text());
		$(this).parent().find('.order').after(control);
	});

 	$('body').on('keypress', '.sequense', function (event) {
 		var row_val = $(this).parent().parent().find('.del-button').attr('id');

         if(event.which === 13){
         	var order_val = $(this).val();
         	if($.isNumeric(order_val)){

				$('#result_output tbody').css('opacity', '0.6');
				$('.table-responsive .loading').fadeIn('fast');

         		var slide_id = row_val.split('-')[1];
         		
         		$.get('/internal-bkn/re-order?up_order='+ order_val +'-'+ slide_id, function(result){
         			if(result != ''){
         				$('#result_output tbody').html(result);
         			}
					$('.table-responsive .loading').fadeOut('fast');
					$('#result_output tbody').css('opacity', '1');         			
         		});

         	}else{
	    		$('#confirm-msg-delete .modal-title').text('Error user input');
	    		$('#confirm-msg-delete .modal-body p').text('Not allow other string for Order field. Number only accept for user input.');
	    		$('#confirm-msg-delete .modal-footer').find('#confirm-ok').hide();
	    		$('#confirm-msg-delete .modal-footer').find('.btn-default').text('Ok');
	    		$('#confirm-msg-delete').modal('show');
         	}
         }
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

	function myControl(myval=null)
	{
		var ctrl = '<input type="text" name="sequense" value="'+ myval +'" class="form-control sequense" />';
		return ctrl;
	}