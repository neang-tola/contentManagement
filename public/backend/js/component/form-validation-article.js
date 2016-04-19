
  $('#articleTitle').on('blur', function(){
    var title_val = $(this).val();

    if(title_val == ''){
      $('#articleTitle').css('border', '1px solid red');
      $('#err_title').text('Menu Title is required field.');
    }else{
      $('#articleTitle').css('border', '1px solid #c7c7cc');
      $('#err_title').text('');
    }
  });

  function isValidate_form_article()
  {
    var status    = true;

    if($('#articleTitle').val() == ''){
      $('#articleTitle').css('border', '1px solid red');
      $('#err_title').text('Article Title is required field.');
      status = false;
    } 

    if($('#articleDes').val() == ''){
      $('#err_des').text('Description is required field.');
      status = false;
    }

    return status;
  }