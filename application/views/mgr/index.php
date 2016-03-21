<?php echo $header; ?>
<div class="am-cf admin-main">
  <!-- sidebar start -->
  <?php echo $sidebar; ?>
  <!-- sidebar end -->

  <!-- content start -->
  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / <small>您的账户概览</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-md-6">
        <div class="am-panel am-panel-default">
          <div class="am-panel-hd am-cf">您的账户信息</div>
          <div class="am-panel-bd">
            <div class="user-info">
              <p>账户UID：<?php echo $this->session->uid; ?></p>
              <p>您的身份：<?php echo $this->user->is_component() ? '服务提供商 | ' : ''; ?> <?php echo $this->user->is_developer() ? '开发者 | ' : ''; ?> 微信公众号用户</p>
              <p>账户余额：<strong><?php echo $this->user->get_money(); ?></strong> 元人民币</p>
              <?php if ($this->user->is_component()) {
                  echo '<p>开放平台账户数：<strong>' . $this->user->get_component_total() . '</strong></p>';
              }?>
              <?php if ($this->user->is_developer()) {
                  echo '<p>已上架APP数：<strong>' . $this->user->get_app_total() . '</strong></p>';
              }?>
              <p>微信号数：<strong><?php echo $this->user->get_app_total(); ?></strong></p>
            </div>
          </div>
        </div>
      </div>
      <div class="am-u-md-6">
          <div class="am-panel am-panel-default">
          <div class="am-panel-hd am-cf">浏览器统计</div>
          <div id="collapse-panel-2" class="am-in">
            <table class="am-table am-table-bd am-table-bdrs am-table-striped am-table-hover">
              <tbody>
              <tr>
                <th class="am-text-center">#</th>
                <th>浏览器</th>
                <th>访问量</th>
              </tr>
              <tr>
                <td class="am-text-center"><img src="<?php echo ROOTPATH; ?>assets/i/examples/admin-chrome.png" alt=""></td>
                <td>Google Chrome</td>
                <td>3,005</td>
              </tr>
              <tr>
                <td class="am-text-center"><img src="<?php echo ROOTPATH; ?>assets/i/examples/admin-firefox.png" alt=""></td>
                <td>Mozilla Firefox</td>
                <td>2,505</td>
              </tr>
              <tr>
                <td class="am-text-center"><img src="<?php echo ROOTPATH; ?>assets/i/examples/admin-ie.png" alt=""></td>
                <td>Internet Explorer</td>
                <td>1,405</td>
              </tr>
              <tr>
                <td class="am-text-center"><img src="<?php echo ROOTPATH; ?>assets/i/examples/admin-opera.png" alt=""></td>
                <td>Opera</td>
                <td>4,005</td>
              </tr>
              <tr>
                <td class="am-text-center"><img src="<?php echo ROOTPATH; ?>assets/i/examples/admin-safari.png" alt=""></td>
                <td>Safari</td>
                <td>505</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd am-cf"> 最近登录记录</div>
            <div class="am-panel-bd">
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                  <thead>
                  <tr>
                    <th>编号</th><th>登录时间</th><th>登录IP</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr><td>1</td><td>John Clark</td><td><a href="#">Business management</a></td></tr>
                  <tr><td>1</td><td>John Clark</td><td><a href="#">Business management</a></td></tr>
                  <tr><td>1</td><td>John Clark</td><td><a href="#">Business management</a></td></tr>
                  <tr><td>1</td><td>John Clark</td><td><a href="#">Business management</a></td></tr>
                  <tr><td>1</td><td>John Clark</td><td><a href="#">Business management</a></td></tr>
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>

  </div>
  <!-- content end -->

</div>

<?php echo $footer; ?>