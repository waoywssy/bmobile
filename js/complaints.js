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
            var jobs;
            if (ctype == "job"){
              jobs = d.jobs || {};
            } else {
              jobs = d.hires || {};
            }

            $("#jobs").find("tr:gt(0)").remove();
            if (jobs.length == 0){
              $("#jobs").append(
                $('<tr/>').append(
                  $('<td />').addClass('info').attr('colspan', '2').attr('align', 'center').append('没有结果'))
              );
              return;
            }
            
            total = d.total > 0 ? d.total : total;

            if (total > per_page){
              pagi.show();
              pagi.pagination('updateItems', total);
            } else {
              pagi.hide();
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
                  $('<tr/>').append($('<td />').append($('<span />')
                                                          .attr('data-toggle', 'modal')
                                                          .attr('data-target', "#jobModal")
                                                          .attr('id', 'id-' + value.id)
                                                          .addClass('jobid')
                                                            .append(value.t)))
                            .append($('<td />').append(btn.clone().attr('id', jid)))
                  );
            })

            $('.jobid').hover(function() {
              $(this).css({'color':'#428bca'});
            }, function() {
              $(this).css({'color':'#333'});
            });

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

            $('#jobModal').on('show.bs.modal', function(e) {
              var job = $(page.j).data('jid-' + e.relatedTarget.id.substring(3));
              page.currentid =  job.id;
              $('#job-title').html(job.t);
              $('#job-contact').html(job.cnt);
              $('#job-phone').html(job.phn);
              $('#job-email').html(job.eml);
              $('#job-location').html(job.l);
              $('#job-address').html(job.add);
              $('#job-start').html(job.s);
              $('#job-end').html(job.e);
              $('#job-duration').html(job.d);
              console.log(job);

              if (ctype == "job"){
                var salary = "";
                if (job.sl != null && job.sh != null && job.sl > 0 && job.sh > 0){
                  salary = String(job.sl) + "~" + String(job.sh) + "元";
                }
                else if (job.sl != null && job.sl > 0){
                  salary = String(job.sl) + "元以上";
                }
                else if (job.sh != null && job.sh > 0){
                  salary = String(job.sh) + "元以下";
                }
                $('#job-salary').html(salary);

                var requirement = "";
                if (job.ty != null && job.ty > 0){
                  requirement += "&middot;" + worktypes[job.ty-1];
                }
                if (job.edu != null && job.edu > 0){
                  requirement += "&middot;" + educations[job.edu-1];
                  if (job.edu > 1 && job.edu < 6){
                    requirement += "以上";
                  }
                  requirement += "学历";
                }
                if (job.exp != null && job.exp > 0){
                  requirement += "&middot;" + String(job.exp) + "年以上经验";
                }
                if (job.sx != null){
                  if (job.sx == 0){
                    requirement += "&middot;" + "女";
                  }
                  else {
                    requirement += "&middot;" + "男";
                  }
                }
                if (job.al != null && job.ah != null && job.al > 0 && job.ah > 0){
                  requirement += "&middot;" + String(job.al) + "~" + String(job.ah) + "岁";
                }
                else if (job.al != null && job.al > 0){
                  requirement += "&middot;" + String(job.al) + "岁以上";
                }
                else if (job.ah != null && job.ah > 0){
                  requirement += "&middot;" + String(job.ah) + "岁以下";
                }
                if (job.hl != null && job.hh != null && job.hl > 0 && job.hh > 0){
                  requirement += "&middot;" + String(job.hl) + "~" + String(job.hh) + "公分";
                }
                else if (job.hl != null && job.hl > 0){
                  requirement += "&middot;" + String(job.hl) + "公分以上";
                }
                else if (job.hh != null && job.hh > 0){
                  requirement += "&middot;" + String(job.hh) + "公分以下";
                }
                if (requirement.length > 0){
                  requirement = requirement.substr(8);
                }

                if (job.rqr){
                  requirement = '<br /><br /><label />' + requirement + '<br />';
                }

                var benefit = "";
                if (job.ss){
                  benefit += "&middot;" + "社保";
                }
                if (job.hf){
                  benefit += "&middot;" + "公积金";
                }
                if (job.av){
                  benefit += "&middot;" + "年休假";
                }
                if (job.hs){
                  benefit += "&middot;" + "住宿";
                }
                if (job.ml){
                  benefit += "&middot;" + "工作餐";
                }
                if (job.tr){
                  benefit += "&middot;" + "无出差";
                }
                if (job.ot){
                  benefit += "&middot;" + "无加班";
                }
                if (job.ns){
                  benefit += "&middot;" + "无夜班";
                }
                if (benefit.length > 0){
                  benefit = benefit.substr(8);
                }
                if (job.dsc){
                  benefit = '<br /><br /><label />' + benefit + '<br />';
                }
                $('#job-company').html(job.c);
                $('#job-requirement').html(job.rqr + requirement);
                $('#job-content').html(job.dsc + benefit);
                $('#job-benefit').html(job.bnf);
              } else {
                $('#job-content').html(job.c);
              }

            })
          })
        .fail(function( jqxhr, textStatus, error ) {
          var err = textStatus + ", " + error;
          alert( "加载基本信息出现问题，请重新刷新页面" + err);
        });
      }

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
            page.u = {}; 
          }) 
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "加载基本信息出现问题，请重新刷新页面" + err);
          });
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
