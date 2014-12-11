(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.companies = {
  attach: function(context, settings) {
      // method to display the information, warning or error
      var info = function(target, msg){
        var t = $('#' + target);
        t.show().append(msg).fadeOut(2000, function(){t.empty();});
      }

      var apiBase = Drupal.settings.basePath + "api/";
      var editUrl = Drupal.settings.basePath + 'company/edit/';
      var jobsUrl = Drupal.settings.basePath;

      var getUrl = apiBase + "manage_university_company";
      var companiesUrl = apiBase + "get_university_companies";

      $('#target').bind('keypress', function(e){
        if(e.which == 13) {
          getData();
        }
      });

      var cache = {}; // cache for company searching terms
      $("#target").autocomplete({
        minLength: 2,   
        source: function(request, response) {
            var term = request.term;
            if (term in cache) {
              response(cache[term]);
              return;
            }

            $.getJSON(companiesUrl, request, function(data, status, xhr) {
              cache[term] = data;
              response(data);
            });
          },
        focus: function(event, ui) {
          $(this).val(ui.item.label);
          return false;
        },
        select: function( event, ui ) {
          $(this).val(ui.item.label);
          return false;
        }
      });

      var company = {};
      var getData = function(){
          $("#editForm").hide();
          $('#mboryi-company-form').find("input[type=text], textarea").val("");

          var target = $.trim($('#target').val());
          if (!target){
            info('msg', "请输入搜索条件");
            return;
          }
          $.post(getUrl, {n:target, t:1,}, function(data) {
            company = data || {};
            if (company.length == 0 ||
              (company.result!== undefined && company.result == 0)){
              $("#model").hide();
              $("#op-edit, #op-jobs").addClass('disabled');
              return;
            }

            $("#model").show();
            company.n = target;
            $("#op-edit").removeClass('disabled');
            $("#op-jobs").removeClass('disabled').find('a').attr('href', 
              jobsUrl + 'company/' + company.i + '/' + company.n + '/jobs');

            $("#company-overview").html(company.o);
            $("#company-benefit").html(company.b);
            $("#company-process").html(company.p);
            $("#company-phone").html(company.phn);
            $("#company-email").html(company.eml);
            $("#company-web").html(company.web);
            $("#company-address").html(company.add);
          }, 
        "json");
      }

    $('#search').bind('click', getData);

    var editForm = function(e){
      if ($(this).hasClass('disabled')){
        return;
      }
      $("#model").hide();
      $("#editForm").show();
      $('#edit-name').closest('div').hide();
      $('#edit-overview-value').val(company.o);
      $('#edit-benefit-value').val(company.b);
      $('#edit-process-value').val(company.p);
      $('#edit-phone').val(company.phn);
      $('#edit-email').val(company.eml);
      $('#edit-web').val(company.web);
      $('#edit-address').val(company.add);
    };
    
    $("#op-edit").bind('click', editForm);

    $("#update").bind('click', function(){
      var apiBase = Drupal.settings.basePath + "api/";
      var postUrl = apiBase + 'manage_university_company';
      var postInfo = function(){
        $.post(postUrl, {
            t:3,
            i: company.i,
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
            info('msg', "更新成功!");
            $('#mboryi-company-form').find("input[type=text], textarea").val("");
            $("#editForm").hide();
          }, 
          "json");
        }

      // the form validator 
      var validator = $("#mboryi-company-form").validate({
        errorPlacement: function(error, element) {
          element.parent().append(error); // default function
        }, 
        errorLabelContainer:'#msg',
        submitHandler: postInfo,
        rules: { 
          email:{
            email: 1,
            maxlength: 32,
          },
        }, 
        messages: {
          email:{
            email: "请输入正确的邮箱",
            maxlength: "最多32个字符",
          },
        },
      });
  })
  $('.alert').hide();
}
}
})(jQuery, Drupal, this, this.document);
