(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.list_recruitments = {
  attach: function(context, settings) {
    // method to display the information, warning or error
    var info = function(target, msg){
      var t = $('#' + target);
      t.show().append(msg).fadeOut(2000, function(){t.empty();});
    }

    var apiBase = Drupal.settings.basePath + "api/";
    var postUrl = apiBase + "manage_university_recruitments";
    var companiesUrl = apiBase + "get_university_companies";

    var btn = $('<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"/>');
    var dbtn = $('<button type="button" class="btn btn-danger"/>');

    var postType = 2; // insert 
    var cr = {};    // currentRecruitment

    /********The auto complete feature for company *******/
    var cache = {}; // cache for company searching terms
    $("#edit-company, #searchc").autocomplete({
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
        $('input[name=company_id]').val(ui.item.value);
        return false;
      },
      select: function( event, ui ) {
        $(this).val(ui.item.label);
        $('input[name=company_id]').val(ui.item.value);
        return false;
      }
    });
    /********The auto complete feature for company *******/


    var listRecruitments = function(){
      var cid = $('input[name=company_id]').val(); 
      var uid = $('input[name=university_id]').val();

      cr.cid = cid;
      cr.uid = uid;
      cr.u = $('#searchu').val();
      cr.c = $('#searchc').val();

      $.post(postUrl, {
          ci: cid, 
          ui: uid, 
          t: 1, 
        }, 
        function(data) {
          var rt = data.r || {};
          var table = $("#recruitments");
          table.find("tr:gt(0)").remove();

          if (rt.length == 0){
            table.append(
              $('<tr/>').append(
                $('<td />').addClass('info').attr('colspan', '4').attr('align', 'center').append('没有结果'))
            );
            return;
          }
          $.each(rt, function(index, value){
            table.append(
              $('<tr/>')//.append($('<td />').addClass('hide').append(value.i))
                        //.append($('<td />').append(value.n))
                        .append($('<td />').append(value.d))
                        .append($('<td />').append(value.p))
                        .append($('<td />').append(btn.clone().html('更改').attr('id', value.i + '-' + uid)))
                        .append($('<td />').append(dbtn.clone().html('删除').attr('id', 'd' + value.i + '-' + uid)))
              );
          });

          // *** feature delete recruitment *** //
          $('.btn-danger').bind('click', function(){
            var button = $(this); 
            var ids = button.attr('id').substr(1).split('-');
            $.post(postUrl, {
                t:4,
                ci:ids[0],
                ui:ids[1],
              },
              function(d) {
                if(d.result==1){
                  $("#recruitments").find("tr:gt(0)").remove();
                  info('info', '删除成功');
                }
              },
              "json");
          })
          // *** feature delete recruitment over *** //
      }, 
      "json");
  }
    $('#myModal').on('show.bs.modal', function (e) {
      var id = e.relatedTarget.id;
      if (id != 'search'){
        var tds = $('#' + id).closest('tr').find('td');
        
        var datetime = $(tds[0]).html().split(' ');

        $('#edit-datetime-datepicker-popup-0').val(datetime[0]);
        $('#edit-datetime-timeEntry-popup-1').val(datetime[1]);
        $('#edit-address').val($(tds[1]).html());
        $('#edit-company').val(cr.c);
        $('#edit-university').val(cr.u);

        postType = 3; // update 
        $('#edit-company, #edit-university').attr('disabled', true);
      } else {
        postType = 2; // insert
        $('#edit-company, #edit-university').attr('disabled', false);
      }
    })

    /********To add recruitment*******/
    var postInfo = function(type){
      // 12:AM - midnight
      // 12:PM - noon
      $.post(postUrl, {
            t: type, 
            d: $('#edit-datetime-datepicker-popup-0').val() + ' ' +  $('#edit-datetime-timeEntry-popup-1').val(), 
            p: $('#edit-address').val(), 
            ci: $('input[name=company_id]').val(), 
            ui: $('input[name=university_id]').val(), 
        }, 
        function(data) {
          // console.log(data);
          if (data.result == 1) {
            if (type == 2){
              info('modal-info', '已添加成功!');
              $('#edit-company').val("");
            } else {
              info('modal-info', '已更新成功!');
              $('#cancel').trigger('click');
              listRecruitments();

              $('#mboryi-recruitments-form')
                .find("input[type=text], textarea").val("");
            }
          }
          
        }, 
        "json");
      }


    /********Autocomplete*******/
    $("#edit-university, #searchu").autocomplete({
      minLength: 2,
      source: function(request, response) {
          var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
          response($.grep(schools, function(value){
            value = value.label || value.value || value;
            return matcher.test(value);
          }))
        },
      focus: function(event, ui) {
        $(this).val(ui.item.label);
        $('input[name=university_id]').val(ui.item.value);
        return false;
      },
      select: function( event, ui ) {
        $(this).val(ui.item.label);
        $('input[name=university_id]').val(ui.item.value);
        return false;
      }
    });
    /********Autocomplete*******/

    var isUniversity = function(name){
      for (var i = schools.length - 1; i >= 0; i--) {
        if (schools[i].label == name){
          return true;
        }
      };
      return false;
    }

    $.validator.addMethod("university", function (value, element) {
        return this.optional(element) || isUniversity(value);
    }, "请填写学校全名");

    // the insert/update form validator 
    var validator = $("#mboryi-recruitments-form").validate({ 
      errorPlacement: function(error, element) {
        element.parent().append(error); // default function 
      }, 
      submitHandler: function(){postInfo(postType)},
      rules:{ 
        university:{ 
          required: 1,
          university: 1,
        },
        company:{ 
          required: 1,
          remote: {
            url: companiesUrl,
            type: "post",
            data: {
              term: function() {
                return $("#edit-company").val();
              },
              check: 1,
            }
          }
        },
        "datetime[date]":{ 
          required: 1,
          date: 1,
        },
        "datetime[time]":{ 
          required: 1,
        },
        address:{ 
          required: 1,
        },
      }, 
      messages:{ 
        university:{ 
          required: "学校不能为空",
          university: "请输入提示框中的学校全名",
        },
        company:{ 
          required: "公司不能为空",
          remote:"公司尚未录入<a href='" + Drupal.settings.basePath + "company/add' target='blank'>立刻添加</a>",
        },
        "datetime[date]":{ 
          required: "日期不能为空",
          date: "日期格式不正确",
        },
        "datetime[time]":{ 
          required: "时间不能为空",
        },
        address:{ 
          required: "举办地点不能为空",
        },
      },
    });

    $('#edit-submit').click(function(){$("#mboryi-recruitments-form").submit()});
    /********To add recruitment*******/


    /********The searching form*******/    
    // the search form validator 
    var validator = $("#search-form").validate({
      errorPlacement: function(error, element) {
        element.parent().append(error); // default function
      }, 
      errorLabelContainer:'#msg',
      submitHandler: listRecruitments,
      rules:{ 
        searchu:{ 
          required: 1,
          university: 1,
        },
        searchc:{ 
          required: 1,
          remote: {
            url: companiesUrl,
            type: "post",
            data: {
              term: function() {
                return $("#searchc").val();
              },
              check: 1,
            }
          }
        },
      }, 
      messages:{
        searchc:{
          required: "公司名称不能为空",
          remote:"公司尚未录入",
        },
        searchu:{
          required: "学校名称不能为空",
          university: "请输入提示框中的学校全名",
        },
      },
    });
    /********The searching form*******/ 
    $('.alert').hide();
}};
})(jQuery, Drupal, this, this.document);
