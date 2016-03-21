<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list">
        <li><a href="<?php echo ROOTPATH; ?>"><span class="am-icon-home"></span> 首页</a></li>
        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#col-account'}"><span class="am-icon-file"></span> 公众号用户模块 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub <?php echo $class == 'Accountclass' ? "am-in" : '';?>" id="col-account">
            <li><a href="<?php echo ROOTPATH; ?>accountclass/showlist/" class="am-cf"><span class="am-icon-th"></span> 公众号列表</a></li>
            <li><a href="<?php echo ROOTPATH; ?>accountclass/info/"><span class="am-icon-plug"></span> 公众号信息</a></li>
          </ul>
        </li>
        <?php if($is_component): ?>
        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#col-component'}"><span class="am-icon-file"></span> 服务商模块 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub <?php echo $class == 'Componentclass' ? "am-in" : '';?>" id="col-component">
            <li><a href="<?php echo ROOTPATH; ?>componentclass/showlist/" class="am-cf"><span class="am-icon-th"></span> 第三方平台列表</a></li>
            <li><a href="<?php echo ROOTPATH; ?>componentclass/info/"><span class="am-icon-plug"></span> 服务商信息</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <?php if($is_developer): ?>
        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#col-developer'}"><span class="am-icon-file"></span> 开发者模块 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub <?php echo $class == 'Developerclass' ? "am-in" : '';?>" id="col-developer">
            <li><a href="<?php echo ROOTPATH; ?>applicationclass/showlist/" class="am-cf"><span class="am-icon-th"></span> APP列表</a></li>
            <li><a href="<?php echo ROOTPATH; ?>applicationclass/info/"><span class="am-icon-plug"></span> 开发者信息</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <li><a href="admin-form.html"><span class="am-icon-pencil-square-o"></span> 表单</a></li>
        <li><a href="#"><span class="am-icon-sign-out"></span> 注销</a></li>
      </ul>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-bookmark"></span> 公告</p>
          <p>时光静好，与君语；细水流年，与君同。—— Amaze UI</p>
        </div>
      </div>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> wiki</p>
          <p>Welcome to the Amaze UI wiki!</p>
        </div>
      </div>
    </div>
  </div>