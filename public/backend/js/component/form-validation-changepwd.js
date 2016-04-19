
  $('#currentPassword').on('blur', function(){
    var pass_val = $(this).val();

    if(pass_val == ''){
      $('#currentPassword').css('border', '1px solid red');
      $('#err_current').text('Current Password is required field.');
    }else{
      $.get('/internal-bkn/check-password?cur_password='+ pass_val, function(data){
        if(data == 'done'){
          $('#currentPassword').css('border', '1px solid #c7c7cc');
          $('#err_current').text('');
        }else{
          $('#currentPassword').css('border', '1px solid red');
          $('#err_current').text('Current Password is not match to current password.');
        }
      });
    }
  });

  $('body').on('blur', '#newPassword',  function() {
      if($(this).val() == ''){
          $('#newPassword').css('border', '1px solid red');
          $('#err_new').text('New Password is required field.');
      }else{
          if($(this).val().length < 6){
            $('#newPassword').css('border', '1px solid red');
            $('#err_new').text('Minimum charachtors length 6 for your new password.');
          }else{
            $('#newPassword').css('border', '1px solid #c7c7cc');
            $('#err_new').text('');
          }
      }
  });

  $('body').on('blur', '#confirmPassword',  function() {
      if($(this).val() == ''){
          $('#confirmPassword').css('border', '1px solid red');
          $('#err_confirm').text('Confirm Password is required field.');
      }else{
          if($('#newPassword').val() != $('#confirmPassword').val()){
              $('#confirmPassword').css('border', '1px solid red');
              $('#err_confirm').text('Confirm Password is not match.');
          }else{
              $('#confirmPassword').css('border', '1px solid #c7c7cc');
              $('#err_confirm').text('');
          } 
      }
  });

  function isValidate_form_password()
  {
    var status    = true;

    if($('#currentPassword').val() == ''){
      $('#currentPassword').css('border', '1px solid red');
      $('#err_current').text('Current Password is required field.');
      status = false;
    }else{
      $.get('/internal-bkn/check-password?cur_password='+ $('#currentPassword').val(), function(data){
        if(data != 'done'){
          $('#currentPassword').css('border', '1px solid red');
          $('#err_current').text('Current Password is not match to current password.');
          status = false;
        }
      });
    }

    if($('#newPassword').val() == ''){
        $('#newPassword').css('border', '1px solid red');
        $('#err_new').text('New Password is required field.');
         status = false;
    }else{
      if($('#newPassword').val().length < 6){
        $('#newPassword').css('border', '1px solid red');
        $('#err_new').text('Minimum charachtors length 6 for your new password.');
        status = false;
      }
    }

    if($('#confirmPassword').val() == ''){
        $('#confirmPassword').css('border', '1px solid red');
        $('#err_confirm').text('Confirm Password is required field.');
          status = false;
    }else{
        if($('#newPassword').val() != $('#confirmPassword').val()){
            $('#confirmPassword').css('border', '1px solid red');
            $('#err_confirm').text('Confirm Password is not match.');
            status = false;
        }
    }

    return status;
  }