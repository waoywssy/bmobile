<script>
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
#edit-datetime{
  padding-left: 0px;
}
#msg label {
  display: block;
}
.ui-front {
  z-index: 9999;
}
</style>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left" role="search" id="search-form">
        <div class="form-group">
          <input id="searchu" name="searchu" type="text" class="form-control" placeholder="学校名称" value="">
        </div>
        <div class="form-group">
        <input id="searchc" name="searchc" type="text" class="form-control" placeholder="公司名称" value="">
        </div>
        <button id="search" class="btn btn-default">搜索</button>
      </form>
      <ul class="nav navbar-form navbar-nav navbar-right">
        <button id="search" class="btn btn-success" data-toggle="modal" data-target="#myModal">新招聘会</button>
      </ul>
    </div>
  </div>
</nav>
<div id="msg" class="alert alert-warning fade in" role="alert"></div>
<div id="info" class="alert alert-success fade in" role="alert"></div>
<table class="table table-bordered table-striped table-responsive" id="recruitments">
<thead>
<tr><th class="col-xs-3">招聘会时间</th><th>地点</th><th class="col-xs-1">更改</th><th class="col-xs-1">删除</th></tr>
</thead>
<tbody>
</tbody>
</table>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">校园招聘会</h4>
      </div>
      <div class="modal-body">
        <div id="modal-msg" class="alert alert-warning fade in" role="alert"></div>
        <div id="modal-info" class="alert alert-success fade in" role="alert"></div>
      <?php
        $form = drupal_get_form('mboryi_recruitments_form');

        $form['datetime']['date']['#attributes']['placeholder'] = '举办日期';
        $form['datetime']['time']['#attributes']['placeholder'] = '举办时间';
        $form['datetime']['date']['#title']                     = '';
        $form['datetime']['time']['#title']                     = '';
//        $form['company']['#field_suffix'] = '<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>';

        hide($form['actions']['submit']);
        echo drupal_render($form);
        //var_dump($form['company']);
      ?>
      </div>
      <div class="modal-footer">
      <?php
        $form['actions']['submit']['#attributes']['class'][] = "btn-primary";
        print render($form['actions']['submit']);
      ?>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
      </div>
    </div>
  </div>
</div>