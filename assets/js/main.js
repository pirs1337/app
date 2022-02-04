$(document).ready(function(){

  if(document.location.pathname != '/'){
    $('img.logo').show();
  }
  if(document.location.pathname == '/assets/views/auth/admin/product/edit.php/'){
    deleteProductImg();
  }
  

  // let currentDate = new Date().toISOString();
  // let minDate = currentDate.split('T')[0];


  function getDate(maxDate = null){
    let currentDate = new Date();
    if(maxDate == 1){
      currentDate.setMonth(currentDate.getMonth() + 6);
    }
    let date = currentDate.toISOString();
    date = date.split('T')[0];
    return date;
  }


  $('input#date').attr({
    min: getDate(),
    max: getDate(1)
  });

  $('input#tel').mask("+7(999) 999-99-99", {autoclear: false, placeholder: ""});

    $("input#tel").click(function(){
        $(this).setCursorPosition(3);
    })

    $(".alert-success").delay(3000).slideUp(300);


    $('input#date').on('input', function(){
      if($('.wrapper-record').length > 0){
        $('.wrapper-record').hide();
        $('button[name="record"]').hide();
      }
    })

    $('input#time').click(function (){
      $('button[name="record"]').show();
    })

})

//fix cursor in masks

$.fn.setCursorPosition = function(pos) {
  if ($(this).get(0).setSelectionRange) {
    $(this).get(0).setSelectionRange(pos, pos);
  } else if ($(this).get(0).createTextRange) {
    var range = $(this).get(0).createTextRange();
    range.collapse(true);
    range.moveEnd('character', pos);
    range.moveStart('character', pos);
    range.select();
  }
};


function deleteProductImg(){
  $('button[name="delete_product_img"]').click(function(e){
      e.preventDefault();
      let img_id = $($(this).prev()).val();
      console.log(img_id);

      $.ajax({
        url: '/app/User/AdminClass.php',
        method: 'POST',
        dataType: 'json',
        data: {img_id: img_id},
        success: function(data){
          if(data.status){
            location.reload();
          }else{
            $('.modal').modal('hide');
            $('.edit-msg').html(`<div class="alert alert-danger" role="alert">${data.msg}</div>`);
          }
        }
      });
  })
}

