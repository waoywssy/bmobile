<script>
	var type = <?php echo $type; ?>;
  var ctype = "<?php echo $complaints_type; ?>";
</script>
<style>
.table {
  table-layout:fixed;
}
.table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
#md-content{
  width:120%!important;
}
</style>

<?php
$module_path = drupal_get_path('module','mboryi');
drupal_add_js($module_path . '/js/complaint_types.js');
drupal_add_js($module_path . '/js/complaints.js');
?>
<table class="table table-bordered table-striped table-responsive" id="jobs">
<thead>
<tr>
<th>
<?php if ($complaints_type == "job"){ ?>
  职位名
<?php } else { ?>
  工种名
<?php } ?>
</th>
<th>处理</th>
</tr>
</thead>
</table>

<ul class="pagination">
  <li class="disabled"><a href="#">&laquo;</a></li>
  <li class="active"><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>
<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="md-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">举报处理</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-responsive" id="complaints">
        <thead>
          <tr><th>举报编码</th><th>举报类型</th><th>举报内容</th><th>举报时间</th></tr>
        </thead>
        </table>
        <form role="form">
          <div class="form-group">
            <label for="result">处理结果</label>
            <?php if ($type == 3){ ?>
              <div id="result">
              同意
              </div>
            <?php } else { ?>
              <div id="result" class="btn-group btn-group-justified">
                <div class="radio">
                  <label>
                    <input type="radio" name="results" id="result1" value="3" checked="">
                    同意
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="results" id="result2" value="2" checked="">
                    拒绝
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="results" id="result3" value="1" checked="">
                    都不是
                  </label>
                </div>
              </div>
            <?php } ?>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
        <?php if ($type == 3){ ?>
        关闭窗口
        <?php } else { ?>
        取消
        <?php } ?>
        </button>
        <?php if ($type != 3){ ?>
        <button type="button" class="btn btn-primary" id="confirm">确认</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>