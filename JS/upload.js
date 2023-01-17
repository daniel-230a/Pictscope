var uploader_view;
var img_url;

$( document ).on('click','#upload_img_btn', function(){
  // clear message on each upload
  $(".alert").empty();
  uploader_view = $('#upload_view').html();
  $('#choose_img').click();


  $("#choose_img").change(function(){
    $('#img_uploader').submit();

    img_url = this;
    $('#choose_img').replaceWith('');
  });

});

$( document ).on('submit','#img_uploader', function(event){
    event.preventDefault();

    $('.rounded_box').html('<div id="myProgress"><div id="myBar"></div></div>');

    form_data = new FormData(this);
    if(form_data) {

      $( document ).on('click','#post_img', function(){
        form_data.append('choose_img_final', "final");
        form_data.append('img_title_inp', $("#img_title_inp").val());
        form_data.append('img_desc_inp', $("#img_desc_inp").val());
        $.ajax({
                url: $("#img_uploader").attr("action"),
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (post_status) {
                    $( ".post_img" ).replaceWith('');
                    display_posts()
                    $(".rounded_box").replaceWith(post_status);
                }
              });
              return false;
      });

      $.ajax({
              url: $("#img_uploader").attr("action"),
              type: 'POST',
              data: form_data,
              processData: false,
              contentType: false,
              cache: false,
              success: function (validation) {
                if (validation == "valid") {
                  $(".alert").empty();
                  readURL(img_url);
                } else {
                  $('#img_uploader').replaceWith(uploader_view);
                  $(".alert").html(validation);

                }
              },
              xhr: function() {
      					var xhr = new XMLHttpRequest();
      					xhr.upload.addEventListener("progress", function(e) {
      						if (e.lengthComputable) {
      							var uploadpercent = e.loaded / e.total;
      							uploadpercent = Math.round(uploadpercent * 100);
      							$('#myBar').css("width", uploadpercent +"%");
      							if (uploadpercent == 100) {
      								$('#myProgress').fadeOut(600);
                      $('#myProgress').replaceWith('<img src="../img/loader.gif" style="width:100px; height:100px;"/>');

      							}
      						}
      					}, false);

      					return xhr;
      				}
            });
            return false;
    }

});





$( document ).on('click','#cancel_upload', function(){
  $('#img_uploader').replaceWith(uploader_view);
});



function readURL(input) {
       if (input.files && input.files[0]) {
           const reader = new FileReader();

           reader.onload = function (e) {
             var img_preview = '' +
              '<div class="upload_header"></div>' +
              '<img id="preview" src="'+ e.target.result +'" />' +
              '</div>' +
              '<input id="img_title_inp" type="text" placeholder="Image Title">' +
              '<textarea id="img_desc_inp" placeholder="Image Description..."/>' +
              '<input class="btn" type="submit" value="Post" name="post_img" id="post_img">' +
              '<input class="btn" type="button" value="Cancel" id="cancel_upload">'
             $('.rounded_box').replaceWith(img_preview);
           }

           reader.readAsDataURL(input.files[0]);
       }
   }
