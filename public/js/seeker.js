//上传头像
$("#upload-img").click(function(){
    $("#upload-input").click().change(function(){
       var formdata = document.getElementById("upload-form");
       var form = new FormData(formdata);
       console.log(form);
       $.ajax({
           url: '/user/avatar',
           type: "POST",
           dataType: "json",
           data:form,
           contentType:false,
           processData:false,
           success:function(filename) {
               $("#upload-img").attr("src",'/images/avatar/'+filename);
               $("#upload-form").append("<input type='hidden' name='filename' value='"+filename+"'>");
           }
       })
    })
})

$(".btn-reply").click(function(){
    var userid = $(this).attr('data-id');
    var username = $(this).attr('data-name');
    var form = $(".card-comment").find("form")
    form.find("#comment").attr("placeholder","回复"+username).focus();
    form.find("input#setid").val(userid);
})