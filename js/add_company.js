(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.add_company = {
  attach: function(context, settings) {
    var apiBase = Drupal.settings.basePath + "api/";
    var postUrl = apiBase + 'manage_university_company';
    var postInfo = function(){
      
      $.post(postUrl, {
          t:2,
          n:$('#edit-name').val(),
          o:$('#edit-overview-value').val(),
          b:$('#edit-benefit-value').val(),
          p:$('#edit-process-value').val(),
          phn:$('#edit-phone').val(),
          eml:$('#edit-email').val(),
          web:$('#edit-web').val(),
          add:$('#edit-address').val(),
        }, 
        function(data) {
          alert('添加成功!');
          $('#mboryi-company-form').find("input[type=text], textarea").val("");
        }, 
        "json");
      }

    // the form validator 
    var validator = $("#mboryi-company-form").validate({
      errorPlacement: function(error, element) {
        element.parent().append(error); // default function
      }, 
      submitHandler: postInfo,
      errorLabelContainer:'#msg',
      rules:{ 
        name:{ 
          required: 1,
          minlength: 2,
          maxlength: 64,
        },
        email:{
          email: 1,
          maxlength: 32,
        },
      }, 
      messages:{
        name:{
          required: "公司名称不能为空",
          minlength: "太短了",
          maxlength: "请不要超过64个字符",
        },
        email:{
          email: "请输入正确的邮箱",
          maxlength: "最多32个字符",
        },
      },
    });
  }
}
})(jQuery, Drupal, this, this.document);
