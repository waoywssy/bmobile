(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.account = {
  attach: function(context, settings) {
    var apiBase = Drupal.settings.basePath + "api/";
    var getUrl = "";

    if (type == 2){
      // 在线用户
      getUrl = apiBase + "get_online_users?";
    } else {
      // 订阅用户
      getUrl = apiBase + "get_users?t=" + type;
    }

    var btn = $('<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">更改</button>');

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
    page.u = {};  // users
    page.currentid = null;

    var getPageData = function(pageNum){
      current_page = pageNum;
      $.getJSON(getUrl + "&p=" + pageNum, 
        function(d) {
          var users = d.users || {};

          $("#users").find("tr:gt(0)").remove();
          if (users.length == 0){
            $("#users").append(
              $('<tr/>').append(
                $('<td />').addClass('info').attr('colspan', '8').attr('align', 'center').append('没有结果'))
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

          $.each(users, function(index, value){
            var uid = value.oi;
            // check if this job has alreay been cached
            var cachedUser = $(page.u).data(uid);
            if (cachedUser === undefined){
              // new user cached
              $(page.u).data(uid, this);
            }

            $("#users").append(
                $('<tr/>').append($('<td />').append(value.nn))
                          .append($('<td />').append(genders[value.sx]))
                          .append($('<td />').append(value.ct))
                          .append($('<td />').append(value.pr))
                          .append($('<td />').append(value.cn))
                          .append($('<td />').append(value.st))
                          .append($('<td />').append(value.cr == null ? 0 : value.cr))
                          .append($('<td />').append(btn.clone().attr('id', uid)))
                );
          })

          $('#myModal').on('show.bs.modal', function (e) {
            var user = $(page.u).data(e.relatedTarget.id);
            console.log(user);
            page.currentid =  user.oi;
            $('#result').find('option:eq(0)').attr('selected', 'selected');

            $("#credits").find("tr:gt(0)").remove();
            $("#credits").append(

              $('<tr/>') 
                .append($('<td />').addClass('content')
                          .append($('<span />').attr('title', user.oi).append(user.oi)))
                .append($('<td />').append(user.nn))
                .append($('<td />').addClass('content')
                          .append($('<span />').attr('title', user.cr == null ? 0 : user.cr)
                              .append(user.cr == null ? 0 : user.cr)))
            );
          })
        })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "加载基本信息出现问题，请重新刷新页面" + err);
      });
    }

    if (type == 3){
      
      var searchUser = function() {
        var by = $("input[name='by']:checked").val();
        var target = $.trim($('#target').val());
        if (!target){
          alert("请输入搜索条件");
          return;
        }
        var params = 't=2';
        if (by == 0){
          // openid
          params += '&oi=' + target;
        } else {
          // nickname
          params += '&nn=' + target;
        }
        getUrl = apiBase + 'get_users?' + params;
        getPageData(1);
      }

      $('#search').bind('click', searchUser);
      $('#target').bind('keypress', function(e){
        if(e.which == 13) {
          searchUser();
        }
      });
    } else {
      getPageData(1);
    }

    var setUrl = apiBase + 'set_user_credit';
    // 注册用户和在线用户
    $("#confirm").click(function(event) {
      
      var parmas = "?oi=" + page.currentid + '&c=' + $("#result option:selected").val();
      $.getJSON(setUrl + parmas, function(d){
        getPageData(current_page);

        $('#myModal').modal('hide'); 
        page.u = {}; 
      }) 
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "加载基本信息出现问题，请重新刷新页面" + err);
      });
    });

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
  }
};
})(jQuery, Drupal, this, this.document);

