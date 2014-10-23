(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.account = {
  attach: function(context, settings) {
      var apiBase = Drupal.settings.basePath + "api/";
      var getUrl = "";
      var per_page = 3;
      var auditUrl = "";
      var btnText = '处理';
      
      if (ctype == "job"){
        getUrl = apiBase + "get_job_complaints?t=" + type;
        auditUrl = apiBase + "audit_job_complaint?t=" + type;
      } else {
        getUrl = apiBase + "get_hire_complaints?t=" + type;
        auditUrl = apiBase + "audit_hire_complaint?t=" + type;
      }

      if (type == 3){
        btnText = '查看';
      }
      var btn = $('<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">' + btnText + '</button>');

      var total = 0;
      var pages = 1;
      
      var pagi = $('#pagination');
      pagi.pagination({
          items: 0,
          itemsOnPage: per_page,
          hrefTextPrefix: '#page=', 
      });
  	  
      // remove those parent menu's link 
      $.getJSON(getUrl, 
        function(d) {
          total = d.total > 0 ? d.total : total;

        	// console.log(d);
          var page = [];
          page.j = {};  // jobs
          page.currentid = null;
          pagi.pagination('updateItems', total); 

          var jobs = {};
          if (ctype == "job"){
            jobs = d.jobs;
          } else {
            jobs = d.hires;
          }

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
          })

          $("#confirm").click(function(event) {
            $('#myModal').modal('hide');
            var parmas = "&i=" + page.currentid + "&r=" + $("input[name='results']:checked").val();
            $.getJSON(auditUrl + parmas, function(d){
              console.log(d);
            }) 
            .fail(function( jqxhr, textStatus, error ) {
              var err = textStatus + ", " + error;
              alert( "加载基本信息出现问题，请重新刷新页面" + err);
            });
          });
        })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "加载基本信息出现问题，请重新刷新页面" + err);
      });
  }
};
})(jQuery, Drupal, this, this.document);
