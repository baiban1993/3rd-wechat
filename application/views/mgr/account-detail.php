<?php echo $header; ?>
<div class="am-cf admin-main">
  <!-- sidebar start -->
  <?php echo $sidebar; ?>
  <!-- sidebar end -->

  <!-- content start -->
<div class="admin-content">
<form action="<?php echo ROOTPATH; ?>componentclass/save" method="post" class="am-form am-form-inline">
  <input type="hidden" name="id" value="<?php echo (isset($item['id'])) ? $item['id'] : '';?>">
  <div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">公众号配置</strong> / <small>Account Setting</small></div>
  </div>

  <div class="am-tabs am-margin" >
    <ul class="am-tabs-nav am-nav am-nav-tabs">
      <li class="am-active"><a href="#baseinfo">基本信息</a></li>
    </ul>

    <div class="am-tabs-bd">
      <div class="am-tab-panel am-fade am-in am-active" id="baseinfo">

        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">
            平台名称
          </div>
          <div class="am-u-sm-8 am-u-md-9">
                <input type="text" name="name" class="am-form-field am-input-sm" value="<?php echo (isset($item['name'])) ? $item['name'] : '';?>">
          </div>
        </div>

        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">
            安全密码
          </div>
          <div class="am-u-sm-8 am-u-md-9">
                <input type="text" name="tmsecret" class="am-form-field am-input-sm" value="<?php echo (isset($item['tmsecret'])) ? $item['tmsecret'] : '';?>">
          </div>
        </div>


        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">授权类别</div>
          <div class="am-u-sm-8 am-u-md-9">
            <select data-am-selected="{btnSize: 'sm'}" name="type">
              <option value="0">无权限集一授权</option>
              <option value="1" <?php if(isset($item['type']) && $item['type']) {echo 'selected';}?>>完全权限集授权</option>
            </select>
          </div>
        </div>

        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">
            AppID
          </div>
          <div class="am-u-sm-8 am-u-md-9">
                <input type="text" name="appid" class="am-form-field am-input-sm" value="<?php echo (isset($item['appid'])) ? $item['appid'] : '';?>">
          </div>
        </div>

        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">
            AppSecret
          </div>
          <div class="am-u-sm-8 am-u-md-9">
                <input type="text" name="appsecret" class="am-form-field am-input-sm" value="<?php echo (isset($item['appsecret'])) ? $item['appsecret'] : '';?>">
          </div>
        </div>

        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">
            公众号消息加解密Key
          </div>
          <div class="am-u-sm-8 am-u-md-9">
                <input type="text" name="encodingAesKey" class="am-form-field am-input-sm" value="<?php echo (isset($item['encodingAesKey'])) ? $item['encodingAesKey'] : '';?>">
          </div>
        </div>

        <div class="am-g am-margin-top">
          <div class="am-u-sm-4 am-u-md-3 am-text-right">
            公众号消息校验Token
          </div>
          <div class="am-u-sm-8 am-u-md-9">
                <input type="text" name="token" class="am-form-field am-input-sm" value="<?php echo (isset($item['token'])) ? $item['token'] : '';?>">
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="am-margin">
    <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
  </div>
</form>
</div>
  <!-- content end -->

</div>

<?php echo $footer; ?>