(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.account = {
  attach: function(context, settings) {

  	// remove those parent menu's link 
	$.getJSON(Drupal.settings.basePath + "api/get_job_complaints?type=" + type, 
        function(d) {
        /*
          if (d.ssn_status == 1){
            $("#name").html(d.name);
            $("#ssn").html(d.ssn).removeClass('red');
            $('#pg-account-security-ssn').remove();
          } 
      	*/
        })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "加载基本信息出现问题，请重新刷新页面" + err);
      });


	//$("#myModal").modal();                       // 默认初始化
	//$("#myModal").modal({ keyboard: false })   // 无键盘初始化
	//$("#myModal").modal('show')                // 初始化并立即调用显示

  }
};
})(jQuery, Drupal, this, this.document);
