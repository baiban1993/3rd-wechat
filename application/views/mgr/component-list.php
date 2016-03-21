<?php echo $header; ?>
<div class="am-cf admin-main">
  <!-- sidebar start -->
  <?php echo $sidebar; ?>
  <!-- sidebar end -->

  <!-- content start -->
  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">第三方平台列表</strong> / <small>Third-party List</small></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
          <div class="am-btn-group am-btn-group-xs">
            <a class="am-btn am-btn-default" href="<?php echo ROOTPATH; ?>componentclass/detail/"><span class="am-icon-plus"></span> 新增</a>
          </div>
        </div>
      </div>
<!--       <div class="am-u-sm-12 am-u-md-3">
  <div class="am-form-group">
    <select data-am-selected="{btnSize: 'sm'}">
      <option value="option1">所有类别</option>
      <option value="option2">IT业界</option>
      <option value="option3">数码产品</option>
      <option value="option3">笔记本电脑</option>
      <option value="option3">平板电脑</option>
      <option value="option3">只能手机</option>
      <option value="option3">超极本</option>
    </select>
  </div>
</div>
      <div class="am-u-sm-12 am-u-md-3">
        <div class="am-input-group am-input-group-sm">
          <input type="text" class="am-form-field">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" type="button">搜索</button>
          </span>
        </div>
      </div>-->
    </div>

    <div class="am-g am-margin-top">
      <div class="am-u-sm-12">
        <form class="am-form">
          <table class="am-table am-table-striped am-table-hover table-main">
            <thead>
              <tr>
                <th class="table-id">ID</th>
                <th class="table-title">开放平台名称</th>
                <th class="table-type">类别</th>
                <th class="table-appid am-hide-sm-only">APPID</th>
                <th class="table-date am-hide-sm-only">最后收到微信verify_ticket日期</th>
                <th class="table-set">操作</th>
              </tr>
          </thead>
          <tbody>

           <?php foreach ($clist as $item): ?>
               <tr>
                 <td><?php echo $item['id']?></td>
                 <td><a href="<?php echo ROOTPATH; ?>componentclass/detail/<?php echo $item['id']?>"><?php echo $item['name']?></a></td>
                 <td><?php echo $item['type'] ? '完全权限集授权' : '无权限集一授权'?></td>
                 <td class="am-hide-sm-only"><?php echo $item['appid']?></td>
                 <td class="am-hide-sm-only"><?php echo $item['VT_create_time'] ? date('Y-m-d H:i:s', $item['VT_create_time']) : '无'?></td>
                 <td>
                   <div class="am-btn-toolbar">
                     <div class="am-btn-group am-btn-group-xs">
                       <a class="am-btn am-btn-success am-btn-xs am-text-default" href="<?php echo ROOTPATH; ?>componentclass/detail/<?php echo $item['id']; ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                       <a class="am-btn am-btn-danger  am-btn-xs am-text-default am-hide-sm-only" href="<?php echo ROOTPATH; ?>componentclass/del/<?php echo $item['id']; ?>"><span class="am-icon-trash-o"></span>删除</a>
                     </div>
                   </div>
                 </td>
               </tr>
           <?php endforeach; ?>



          </tbody>
        </table>
          <div class="am-cf">
  共 <?php echo $total; ?> 条记录
  <?php echo Pager($total, $nowpage, '<?php echo ROOTPATH; ?>componentclass/showlist/'); ?>
</div>
        </form>
      </div>

    </div>
  </div>
  <!-- content end -->

</div>

<?php echo $footer; ?>