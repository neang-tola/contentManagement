    $('body').on('click', '.status-c', function(){
       var val_id = $(this).attr('id');
	   var status_id  = val_id.split('-')[2];
	   var category_id= val_id.split('-')[1];
	   
	   $.get('/internal-bkn/change-status-category?cid='+ category_id +'-'+ status_id, function(result){
		   if(result == 'success'){
			   if(status_id == 0){
				   $('#'+ val_id).find('i').attr('class', 'inactive-button');
				   $('#'+ val_id).attr('id', 'status-'+ category_id +'-1');
			   }else{
				   $('#'+ val_id).find('i').attr('class', 'active-button');
				   $('#'+ val_id).attr('id', 'status-'+ category_id +'-0');
			   }
		   }
	   });
    });

    $('body').on('click', '.show-f', function(){
       var val_id = $(this).attr('id');
	   var status_id  = val_id.split('-')[2];
	   var category_id= val_id.split('-')[1];
	   
	   $.get('/internal-bkn/change-front-category?cid='+ category_id +'-'+ status_id, function(result){
		   if(result == 'success'){
			   if(status_id == 0){
				   $('#'+ val_id).find('i').attr('class', 'no-button');
				   $('#'+ val_id).attr('id', 'status-'+ category_id +'-1');
			   }else{
				   $('#'+ val_id).find('i').attr('class', 'yes-button');
				   $('#'+ val_id).attr('id', 'status-'+ category_id +'-0');
			   }
		   }
	   });
    });

	$('body').on('click', '.del-button', function(){
		$(this).parent().parent().attr('id', 'active-row-delete');
		var del_id = $(this).attr('id').split('-')[1];
		var del_title = $(this).parent().parent().find('.category-title').text();
		$('#confirm-msg-delete .modal-body p').attr('id', 'did-'+ del_id);
		$('#confirm-msg-delete .modal-body p').find('span').text(del_title);
		$('#confirm-msg-delete').modal('show');
	});
	
	$('body').on('hidden.bs.modal', '#confirm-msg-delete', function(){
		$('#active-row-delete').removeAttr('id');
	});
	
	$('body').on('click', '#confirm-ok', function(){
		var did = $('#confirm-msg-delete .modal-body p').attr('id').split('-')[1];
		
		$.get('/internal-bkn/delete-category?did='+ did, function(deleted){
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
		var first_li   = '<li><a href="/internal-bkn/loading-category-list?page=1">«</a></li>';
		var last_li    = '<li><a href="/internal-bkn/loading-category-list?page='+ total_li +'" rel="next">»</a></li>';

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
						pagin_li += '<li><a href="/internal-bkn/loading-category-list?page='+ k +'">'+ k +'</a></li>';
					}
				}else{
					pagin_li += '<li><a href="/internal-bkn/loading-category-list?page='+ k +'">'+ k +'</a></li>';
				}

			}
		} // End total_li
			
		if(pagin_li != ""){
			pagin_ul = '<ul class="pagination">'+ first_li + pagin_li + last_li + '</ul>';
		}

		$.get('/internal-bkn/loading-category-list?page='+ page, function(data){
			if(data != ""){
		
				$('#result_output tbody').html(data);
				$('#list-pagin').html(pagin_ul);
					
			}
			$('.table-responsive .loading').fadeOut('fast');
			$('#result_output tbody').css('opacity', '1');
		});
	});

	$('#find_category').on('submit', function(e){
		e.preventDefault();
		var pagin 	   = $('#list-pagin').html();
		var key_search = $('#key_word').val();
		var pagin_ul   = '';
		var pagin_li   = '';

		$('#result_output tbody').css('opacity', '0.6');
		$('.table-responsive .loading').fadeIn('fast');

		if(pagin != ''){
			var total_li   = $('ul.pagination li').length - 2;
			var first_li   = '<li><a href="/internal-bkn/loading-category-list?page=1">«</a></li>';
			var last_li    = '<li><a href="/internal-bkn/loading-category-list?page='+ total_li +'" rel="next">»</a></li>';
			
			if(total_li > 0){
				for(var k=1; k<=total_li; k++){
					if(k == 1){
						pagin_li += '<li class="active"><a href="/internal-bkn/loading-category-list?page='+ k +'">'+ k +'</a></li>';
					}else{
						pagin_li += '<li><a href="/internal-bkn/loading-category-list?page='+ k +'">'+ k +'</a></li>';
					}
				}
			} // End total_li
				
			if(pagin_li != ""){
				pagin_ul = '<ul class="pagination">'+ first_li + pagin_li + last_li + '</ul>';
			}
		}
		
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
			success: function(result){
				$('#result_output tbody').html(result);
				if(key_search == ''){
					if(pagin != ''){
						$('#list-pagin').html(pagin_ul).show();
					}
				}else{
					if(pagin != ''){
						$('#list-pagin').hide();
					}
				}

				$('.table-responsive .loading').fadeOut('fast');
				$('#result_output tbody').css('opacity', '1');
			}
		});
	});