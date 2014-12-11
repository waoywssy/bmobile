(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.list_jobs = {
  attach: function(context, settings) {
    // method to display the information, warning or error
    var info = function(target, msg){
      var t = $('#' + target);
      t.show().append(msg).fadeOut(2000, function(){t.empty();});
    }

    var apiBase = Drupal.settings.basePath + "api/";
    var postUrl = apiBase + "manage_university_company_jobs";

    var btn = $('<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"/>');
    var dbtn = $('<button type="button" class="btn btn-danger"/>');
    var badge = $('<span class="badge"/>');
    var tip = $('<span data-toggle="tooltip" data-placement="right" class="tips" title=""/>');
//    var sign = $('<span class="glyphicon glyphicon-info-sign" />');

    var postType = 2; // insert
    var jobid;  // the current jobid

    var jobCache = [];

    var listJobs = function(){
      $.post(postUrl, {
          t:1,
          ci:company_id,
        }, 
        function(d) {
          jobs = d.j || {};
          $("#jobs").find("tr:gt(0)").remove();

          if (jobs.length == 0){
            $("#jobs").append(
              $('<tr/>').append(
                $('<td />').addClass('info').attr('colspan', '5').attr('align', 'center').append('没有结果'))
            );
            return;
          }

          $.each(jobs, function(index, value){
            var jid = value.i;
            jobCache[jid] = value;
            $("#jobs").append(
                $('<tr/>').append($('<td />').append(tip.clone().attr('data-original-title', value.c + value.s).append(value.t))
                                             .append(badge.clone().append(value.tt))
                                             .append('<br/><br/><span class="light-gray">' + value.p + '</span>'))
                          .append($('<td />').append(value.e))
                          .append($('<td />').append(value.m))
                          .append($('<td />').append(btn.clone().html('更改').attr('id', jid)))
                          .append($('<td />').append(dbtn.clone().html('删除').attr('id', 'd' + jid)))
                );
          })
          console.log(jobCache);

          $('.tips').tooltip({delay: { "show": 500, "hide": 100 }});

          // *** feature delete job *** //
          $('.btn-danger').bind('click', function(){
            var button = $(this); 
            $.post(postUrl, {
                t:4,
                ci:company_id,
                ji:button.attr('id').substr(1),
              }, 
              function(d) {
                if(d.result==1){
                  $(button).closest('tr').remove();
                }
              },
              "json");
          })
          // *** feature delete job over *** //
      }, 
      "json");
  }

  $('#myModal').on('show.bs.modal', function (e) {
    var id = e.relatedTarget.id;
    jobid = id;
    if (id != 'search'){
      var tds = $('#' + id).closest('tr').find('td');
      
      $('#edit-title').val(jobCache[id].t);
      $('#edit-major-value').val(jobCache[id].m);
      $('#edit-edu').val(jobCache[id].e);
      $('#edit-place').val(jobCache[id].p);
      $('#edit-salary').val(jobCache[id].s);
      $('#edit-total').val(jobCache[id].tt);
      $('#edit-content-value').val(jobCache[id].c);

      postType = 3; // update 
      $('#edit-title').attr('disabled', true);
    } else {
      postType = 2; // insert
      $('#edit-title').attr('disabled', false);
      $('#mboryi-job-form').find("input[type=text], textarea").val("");
    }
  })

    var postInfo = function(type){
      var postParams = 
        {
            t:type,
            ci: company_id,
            m:$('#edit-major-value').val(),
            e:$('#edit-edu').val(),
            p:$('#edit-place').val(),
            s:$('#edit-salary').val(),
            tt:$('#edit-total').val(),
            c:$('#edit-content-value').val(),
        };
      if (type==3){
        postParams.ji = jobid; 
      } else {
        postParams.jt = $('#edit-title').val();
      }

      $.post(postUrl, postParams, 
        function(data) {
          info('modal-info', '添加成功!');
          if (type==3){
            $('#cancel').trigger('click');
          }
          $('#mboryi-job-form').find("input[type=text], textarea").val("");
          listJobs();
        }, 
        "json");
      }

    // the form validator 
    var validator = $("#mboryi-job-form").validate({
      errorPlacement: function(error, element) {
        element.parent().append(error); // default function
      }, 
      submitHandler: function(){postInfo(postType)},
      rules:{ 
        title:{ 
          required: 1,
          minlength: 2,
          maxlength: 64,
        },
        total:{ 
          number: true,
          min: 1,
        },
      }, 
      messages:{
        title:{
          required: "岗位名不能为空",
          minlength: "太短了",
          maxlength: "请不要超过64个字符",
        },
        total:{
          number: "请填写数字",
          min: "招聘人数至少为1",
        },
      },
    });

    $('#edit-submit').click(function(){$("#mboryi-job-form").submit()});

    listJobs();
    $('.alert').hide();
}};
})(jQuery, Drupal, this, this.document);
