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
.jobid{
  cursor: pointer;
}
.form-group span{
  margin-top: 7px;
  display: inline-block;
}
.form-group span.multi{
  display: inline;
}
</style>

<?php
$module_path = drupal_get_path('module','mboryi');
drupal_add_js($module_path . '/js/complaint_types.js');
drupal_add_js($module_path . '/js/jquery.simplePagination.js');
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

<ul class="pagination" id="pagination"></ul>
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
              <div id="result" ></div>
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
            <?php if ($type == 1){ ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="results" id="result0" value="0" checked="">
                    需要调查
                  </label>
                </div>
            <?php } ?>
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

<div class="modal" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="md-content1">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="jobModalLabel">详细信息</h4>
      </div>
      <div class="modal-body">
        <form role="form" class="form-horizontal">
          <div class="form-group input-append">
            <label for="job-title">工作标题</label>
            <span id="job-title"></span>
          </div>
          <?php if ($complaints_type == "hire"){?>
          <div class="form-group">
            <label for="job-content">工作简介</label>
            <span id="job-content" class="multi"></span>
          </div>
          <div class="form-group">
            <label for="job-location">工作地</label>
            <span id="job-location" ></span>
          </div>
          <div class="form-group">
            <label for="job-contact">联系人</label>
            <span id="job-contact" ></span>
          </div>
          <?php } else { ?>
          <div class="form-group">
            <label for="job-company">工作单位</label>
            <span id="job-company" ></span>
          </div>
          <div class="form-group">
            <label for="job-salary">月薪</label>
            <span id="job-salary" ></span>
          </div>
          <div class="form-group">
            <label for="job-content">工作简介</label>
            <span id="job-content" class="multi"></span>
          </div>
          <div class="form-group">
            <label for="job-requirement">工作要求</label>
            <span id="job-requirement" class="multi"></span>
          </div>
          <div class="form-group">
            <label for="job-benefit">工作福利</label>
            <span id="job-benefit"></span>
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="job-phone">联系电话</label>
            <span id="job-phone" ></span>
          </div>
          <div class="form-group">
            <label for="job-email">EMail</label>  
            <span id="job-email" ></span>
          </div>
          <div class="form-group">
            <label for="job-address">联系地址</label>
            <span id="job-address" ></span>
          </div>
          <div class="form-group">
            <label for="job-start">发布日期</label>
            <span id="job-start" ></span>
          </div>
          <div class="form-group">
            <label for="job-end">终止日期</label>
            <span id="job-end" ></span>
          </div>
          <?php if ($complaints_type == "hire"){?>
          <div class="form-group">
            <label for="job-duration">期限天数</label>
            <span id="job-duration" ></span>天
          </div>
          <?php }?>
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
        <?php } ?>
      </div>
    </div>
  </div>
</div>
