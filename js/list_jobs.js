(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.list_jobs = {
  attach: function(context, settings) {
    var apiBase = Drupal.settings.basePath + "api/";
    var postUrl = apiBase + "manage_university_company_jobs";

    var btn = $('<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"/>');
    var dbtn = $('<button type="button" class="btn btn-danger"/>');

    var postType = 2; // insert
    var jobid;  // the current jobid

    var listJobs = function(){
      $.post(postUrl, {
          t:1,
          ci:company_id,
        }, 
        function(d) {
          var jobs = d.j || {};
          $("#jobs").find("tr:gt(0)").remove();

          if (jobs.length == 0){
            $("#jobs").append(
              $('<tr/>').append(
                $('<td />').addClass('info').attr('colspan', '9').attr('align', 'center').append('没有结果'))
            );
            return;
          }

          $.each(jobs, function(index, value){
            var jid = value.i;
            $("#jobs").append(
                $('<tr/>').append($('<td />').append(value.t))
                          .append($('<td />').append(value.m))
                          .append($('<td />').append(value.e))
                          .append($('<td />').append(value.p))
                          .append($('<td />').append(value.s))
                          .append($('<td />').append(value.tt))
                          .append($('<td />').append(value.c))
                          .append($('<td />').append(btn.clone().html('更改').attr('id', jid)))
                          .append($('<td />').append(dbtn.clone().html('删除').attr('id', 'd' + jid)))
                );
          })

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
    if (id != 'search'){
      jobid = id;
      var tds = $('#' + id).closest('tr').find('td');
      
      $('#edit-title').val(tds[0].innerHTML);
      $('#edit-major-value').val(tds[1].innerHTML);
      $('#edit-edu').val(tds[2].innerHTML);
      $('#edit-place').val(tds[3].innerHTML);
      $('#edit-salary').val(tds[4].innerHTML);
      $('#edit-total').val(tds[5].innerHTML);
      $('#edit-content-value').val(tds[6].innerHTML);

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
          // alert('添加成功!');
          $('#cancel').trigger('click');
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
}};
})(jQuery, Drupal, this, this.document);
