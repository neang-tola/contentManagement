// Check validation form of Menu

  $('#menuTypeLink').on('change', function(){
    var var_sel = $(this).val();
    if(var_sel == 'internal'){
      $('.internal').show('fast');
      $('.external').hide('fast');
    }else{
      $('.internal').hide('fast');
      $('.external').show('fast');
    }
  });

  $('#menuContentType').on('change', function(){
    var var_type = $(this).val();
    $.get('/internal-bkn/content-type-menu?ct_id='+ var_type, function(result){
      if(result != ''){
        $('#menuContent').css('border', '1px solid #c7c7cc');
        $('#menuContent').html(result);
        $('#err_content').text('');
      }else{
        $('#menuContent').css('border', '1px solid red');
        $('#menuContent').html('<option value="">Not found</option>');
        $('#err_content').text('There are no content was found.');
      }
    });
  });

  $('#menuOrder').on('input', function(){
    var order_val = $(this).val();
    if($.isNumeric(order_val) == true){
      $('#menuOrder').css('border', '1px solid #c7c7cc');
      $('#err_order').text('');
    }else{
      $('#menuOrder').css('border', '1px solid red');
      $('#err_order').text('Menu Order is number only.');
    }
  });

  $('#menuLink').on('input', function(){
    var link_val = $(this).val();
    if(link_val == ''){
      $('#menuLink').css('border', '1px solid red');
      $('#err_link').text('Menu Link is required field.');
    }else{
      $('#menuLink').css('border', '1px solid #c7c7cc');
      $('#err_link').text('');
    }
  });

  $('#menuLink').on('blur', function(){
    var link_val = $(this).val();
    var link_id  = $('#menuId').val();
    var chk_type = $('#menuTypeLink').val();

    if(chk_type == 'internal'){
      $.get('/internal-bkn/check-link-menu?m_link='+ link_val +'&m_id='+ link_id, function(data){
        if(data == 'success'){
          $('#menuLink').css('border', '1px solid #c7c7cc');
          $('#err_link').text('');
        }else{
          $('#menuLink').css('border', '1px solid red');
          $('#err_link').text('Menu Link is exist used. Please try another one.');
        }
      });
    }
  });

  $('#menuTitle').on('blur', function(){
    var title_val = $(this).val();

    if(title_val === ''){
      $('#menuTitle').css('border', '1px solid red');
      $('#err_title').text('Menu Title is required field.');
    }else{
      $('#menuTitle').css('border', '1px solid #c7c7cc');
      $('#err_title').text('');
    }
  });

  function isValidate_form_menu()
  {
    var status    = true;
    var order_val = $('#menuOrder').val();
    var var_type  = $('#menuContentType').val();

    if($('#menuContent').val() == ''){
      $('#menuContent').css('border', '1px solid red');
      $('#err_content').text('There are no content was found.');
      status = false;
    }

    if($.isNumeric(order_val) == false){
      $('#menuOrder').css('border', '1px solid red');
      $('#err_order').text('Menu Order is number only.');
      status = false;
    }
    
    if($('#menuTitle').val() == ''){
      $('#menuTitle').css('border', '1px solid red');
      $('#err_title').text('Menu Title is required field.');
      status = false;
    }    

    if($('#menuLink').val() == ''){
      $('#menuLink').css('border', '1px solid red');
      $('#err_link').text('Menu Link is required field.');
      status = false;
    }

    if($('#err_link').text() != ''){
      status = false;
    }

    return status;
  }