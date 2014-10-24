(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.account = {
  attach: function(context, settings) {

	$.getJSON(Drupal.settings.basePath + "api/get_job_complaints?t=" + type, 
        function(d) {
        	console.log(d);

        })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "加载基本信息出现问题，请重新刷新页面" + err);
      });
  }
};
})(jQuery, Drupal, this, this.document);
