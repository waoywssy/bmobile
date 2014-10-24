(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.account = {
  attach: function(context, settings) {

      var apiBase = Drupal.settings.basePath + "api/";
      var getUrl = "";
      var auditUrl = "";
      
      var btnText = type == 3 ?  '查看' : '处理';

      if (ctype == "job"){
        getUrl = apiBase + "get_job_complaints?t=" + type;
        auditUrl = apiBase + "audit_job_complaint?";
      } else {
        getUrl = apiBase + "get_hire_complaints?t=" + type;
        auditUrl = apiBase + "audit_hire_complaint?";
      }

      var btn = $('<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">' + btnText + '</button>');

      var per_page = 3;
      var max_pages = 50;
      var total = 0;
      var pages = 1;
      var current_page = 1;
      
      var pagi = $('#pagination');
      pagi.pagination({
          items: 0,
          itemsOnPage: per_page,
          hrefTextPrefix: '#page=', 
          prevText: '前一页',
          nextText: '后一页',
      });
      pagi.hide();

      var page = [];
      page.j = {};  // jobs
      page.currentid = null;

      var getPageData = function(pageNum){
        current_page = pageNum;
        $.getJSON(getUrl + "&p=" + pageNum, 
          function(d) {
            total = d.total > 0 ? d.total : total;

            if (total > per_page){
              pagi.show();
              pagi.pagination('updateItems', total);
            } else {
              pagi.hide();
            }

            var jobs = {};
            if (ctype == "job"){
              jobs = d.jobs;
            } else {
              jobs = d.hires;
            }

            $("#jobs").find("tr:gt(0)").remove();
            $.each(jobs, function(index, value){
              var jid = 'jid-' + value.id;
              // check if this job has alreay been cached
              var cachedJob = $(page.j).data(jid);
              if (cachedJob === undefined){
                // new company cached
                $(page.j).data(jid, this);
              }

              $("#jobs").append(
                  $('<tr/>').append($('<td />').append(value.t))
                            .append($('<td />').append(btn.clone().attr('id', jid)))
                  );
            })

            $('#myModal').on('show.bs.modal', function (e) {

              var job = $(page.j).data(e.relatedTarget.id);
              page.currentid =  job.id;

              $("#complaints").find("tr:gt(0)").remove();
              $.each(job.complaints, function(index, value){
                $("#complaints").append(
                    $('<tr/>').append($('<td />').append(value.i))
                              .append($('<td />').append(complaint_types[value.tp - 1]))
                              .append($('<td />').addClass('content').append($('<span />').attr('title', value.c).append(value.c)))
                              .append($('<td />').append(value.tm))
                    );
              })

              if (type == 3){
                // 已处理
                var r = job.complaints[0].r;
                r = r == null ? -1 : r;
                $('#result').html(complaint_results[r + 2]);
              }
            })

            if (type != 3){
              // 未处理和处理中
              $("#confirm").click(function(event) {
                
                var parmas = "&i=" + page.currentid + '&t=';
                var checked = $("input[name='results']:checked").val();
                if (checked != 0){
                  // 已处理
                  parmas += "3&r=" + checked;
                } else {
                  // 处理中
                  parmas += "2&r=1";
                }
                
                $.getJSON(auditUrl + parmas, function(d){
                  console.log(d);
                  getPageData(current_page);

                  $('#myModal').modal('hide');  
                }) 
                .fail(function( jqxhr, textStatus, error ) {
                  var err = textStatus + ", " + error;
                  alert( "加载基本信息出现问题，请重新刷新页面" + err);
                });
              });
            }
          })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "加载基本信息出现问题，请重新刷新页面" + err);
        });
      }

      $(window).bind('hashchange', function(){
        var hash = window.location.hash;
        var page = 1;
        if (hash.length > 1){
          hash = hash.slice(1);
          var params = hash.split("&");
          for (var i = 0; i < params.length; i++){
            var pairs = params[i].split("=");
            if (pairs[0] == "page"){
              page = Number(pairs[1]);
              if (page > max_pages) {
                page = max_pages;
              }
              else if (page < 1) {
                page = 1;
              }
              break;
            }
          }
          getPageData(page);
          pagi.pagination('selectPage', page);
        }
  	  });
      getPageData(1);
    //$(window).trigger('hashchange');
  }
};
})(jQuery, Drupal, this, this.document);
