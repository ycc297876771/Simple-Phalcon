<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="<?= $this->url->get('dashboard/index') ?>">控制面板</a>
        </li>
        <li>
            <a href="<?= $this->url->get('menu/index') ?>">导航管理</a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="col-lg-12">
        <div class="alert alert-block alert-warning">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            <strong>注意！</strong>
            导航管理作用于前台界面的菜单栏（即导航条）
        </div>

        <div class="btn-panel">
            <a href="<?= $this->url->get('menu/write') ?>" class="btn btn-success btn-sm" role="button">新增菜单</a>
            <a href="<?= $this->url->get('menu/refresh') ?>" class="btn btn-pink btn-sm" role="button">清除菜单缓存</a>
        </div>


        <div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="lighter">
                    <i class="icon-star orange"></i>
                    <a href="<?= $this->url->get('menu/index') ?>">导航管理</a>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        菜单列表
                    </small>
                </h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped table-hover tree-grid" id="menu-table">
                        <thead>
                        <tr>
                            <th>
                                <i class="icon-caret-right blue"></i>
                                菜单名称
                            </th>
                            <th>
                                <i class="icon-caret-right blue"></i>
                                链接
                            </th>
                            <th>
                                <i class="icon-caret-right blue"></i>
                                排序
                            </th>
                            <th>
                                <i class="icon-caret-right blue"></i>
                                更新时间
                            </th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <?php if (!empty($menuList)) { ?>
                            <tbody>
                                <?php foreach ($menuList as $menu) { ?>
                                    <?php if (!empty($menu['parent_mid'])) { ?>
                                        <tr class="treegrid-<?= $menu['mid'] ?> treegrid-parent-<?= $menu['parent_mid'] ?>">
                                    <?php } else { ?>
                                        <tr class="treegrid-<?= $menu['mid'] ?>">
                                    <?php } ?>
                                    <td>
                                        <a href="<?= $this->url->get('menu/write?mid=' . $menu['mid']) ?>" title="编辑菜单">
                                            <?= $menu['menu_name'] ?>
                                        </a>
                                    </td>
                                    <td><?= $menu['menu_url'] ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="menu-sort-block" data-name="sort"
                                           data-url="<?= $this->url->get('menu/savesort') ?>"
                                           data-pk="<?= $menu['mid'] ?>" data-type="text"
                                           data-placement="top" data-title="修改菜单排序">
                                            <?= $menu['sort'] ?>
                                        </a>
                                    </td>
                                    <td><?= $menu['modify_time'] ?></td>
                                    <td>
                                        <a class="btn btn-xs btn-success" href="<?= $this->url->get('menu/write?parentmid=' . $menu['mid']) ?>">
                                            <i class="icon-plus bigger-120"></i>
                                        </a>
                                        <a class="btn btn-xs btn-info" href="<?= $this->url->get('menu/write?mid=' . $menu['mid']) ?>">
                                            <i class="icon-edit bigger-120"></i>
                                        </a>
                                        <button class="btn btn-xs btn-danger delete-menu" data-url="<?= $this->url->get('menu/delete?mid=' . $menu['mid']) ?>">
                                            <i class="icon-trash bigger-120"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        <?php } else { ?>
                            <tbody>
                            <tr>
                                <td colspan="8">暂无数据</td>
                            </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="<?= $this->url->getStatic('bootstrap-editable/css/bootstrap-editable.css?_v=') . $assetsVersion ?>" rel="stylesheet"/>
<script src="<?= $this->url->getStatic('bootstrap-editable/js/bootstrap-editable.min.js?_v=') . $assetsVersion ?>"></script>
<script>
    $.fn.editable.defaults.mode = 'popup';
    $('.menu-sort-block').editable({
        params:function(params){
            params.sort = params.value;
            params.mid = params.pk;
            if(params.sort <= 0 || params.sort > 999){
                params.sort = 999;
            }
            return params;
        },
        success:function(response, value){
            if (typeof response !== 'object') response = JSON.parse(response);
            if(response.code == 1){
                tips_message(response.message, 'success');
            }else{
                tips_message(response.message, 'error');
            }
            return true;
        },
        error:function(response){
            tips_message('网络错误，请重试');
        },
        display:function(value){
            if(value <= 0 || value > 999){
                value = 999;
            }
            $(this).html(value);
        }
    });

    $('.delete-menu').on('click', function(){
        var dataUrl = $.trim($(this).attr('data-url'));
        if(!window.confirm('确定要删除选中菜单吗？此操作不可挽回')){
            return false;
        }
        window.location.href = dataUrl;
    });
</script>