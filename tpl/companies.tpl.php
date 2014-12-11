<?php
global $base_url;
drupal_add_library('system', 'ui.autocomplete');
?>
<script>
</script>
<style>
.form-group span{
  margin-top: 7px;
  display: inline-block;
}
.form-group span.multi{
  display: inline;
}
</style>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <div class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input id="target" type="text" class="form-control" placeholder="公司名称" value="深圳市金融联客户服务中心股份有限公司">
        </div>
        <button id="search" class="btn btn-default">搜索</button>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">操作<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo $base_url; ?>/company/add">录入新公司</a></li>
            <li class="divider"></li>
            <li id="op-edit" class="disabled"><a href="#">编辑当前公司</a></li>
            <li id="op-jobs" class="disabled"><a href="#">查看当前公司工作</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div id="msg" class="alert alert-warning fade in" role="alert" style="display:none"></div>
<div id="info" class="alert alert-success fade in" role="alert" style="display:none"></div>
<br />
<div class="modal-body" style="display:none" id="model">
  <div id="modal-msg" class="alert alert-warning fade in" role="alert"></div>
  <div id="modal-info" class="alert alert-success fade in" role="alert"></div>
  <form role="form" class="form-horizontal">
    <div class="form-group">
      <label for="company-overview">公司简介</label>
      <span id="company-overview" class="multi"></span>
    </div>
    <div class="form-group">
      <label for="company-benefit">公司福利</label>
      <span id="company-benefit" class="multi"></span>
    </div>
    <div class="form-group">
      <label for="company-process">应聘流程</label>
      <span id="company-process" class="multi"></span>
    </div>
    <div class="form-group">
      <label for="company-phone">联系电话</label>
      <span id="company-phone" ></span>
    </div>
    <div class="form-group">
      <label for="company-email">电子邮箱</label>  
      <span id="company-email" ></span>
    </div>
    <div class="form-group">
      <label for="company-web">官方网址</label>
      <span id="company-web" ></span>
    </div>
    <div class="form-group">
      <label for="company-address">联系地址</label>
      <span id="company-address" ></span>
    </div>
  </form>
</div>
<div id="editForm" style="display:none">
<?php
  $form = drupal_get_form('mboryi_company_form');
  $form['actions']['submit'] = array(
      '#id'    =>'update',
      '#type'  => 'submit',
      '#value' => t('更新'),
    );
  $module_path = drupal_get_path('module','mboryi');
  $form['#attached'] = array(
      'js' => array(
        "$module_path/js/jquery.validate.js",
        "$module_path/js/companies.js",
      ),
  );
  echo drupal_render($form);
?>
</div>