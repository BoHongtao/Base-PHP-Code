<?php
/* Smarty version 3.1.30, created on 2017-06-14 14:42:30
  from "E:\practice\mvcpractice\App\Back\View\category\categoryIndex.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5940dad62a7634_81449641',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4074cfe6ae8248f069f3e3a44e72ef16069ba42' => 
    array (
      0 => 'E:\\practice\\mvcpractice\\App\\Back\\View\\category\\categoryIndex.html',
      1 => 1497421885,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5940dad62a7634_81449641 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>博客后台</title>
    <link rel="stylesheet" type="text/css" href="Public/Back/css/app.css" />
    <?php echo '<script'; ?>
 type="text/javascript" src="Public/Back/js/app.js"><?php echo '</script'; ?>
>
</head>
<body>
<div class="wrapper">

    <!-- START HEADER -->
    <div id="header">
        <!-- logo -->
        <div class="logo">	<a href="?"><span class="logo-text text-center font18">博客后台</span></a>	</div>

        <!-- notifications -->
        <div id="notifications">
            <div class="clear"></div>
        </div>

        <!-- quick menu -->
        <div id="quickmenu">
            <a href="#" class="qbutton-left tips" title="新增一篇博客"><img src="Public/Back/img/icons/header/newpost.png" width="18" height="14" alt="new post" /></a>
            <a href="#" class="qbutton-right tips" title="直达前台"><img src="Public/Back/img/icons/sidemenu/magnify.png" width="18" height="14" alt="new post" /></a>
            <div class="clear"></div>
        </div>

        <!-- profile box -->
        <div id="profilebox">
            <a href="#" class="display">
                <img src="Public/Back/img/simple-profile-img.jpg" width="33" height="33" alt="profile"/> <span>管理员</span> <b>昵称</b>
            </a>

            <div class="profilemenu">
                <ul>
                    <li><a href="#">退出</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- END HEADER -->

    <!-- START MAIN -->
    <div id="main">
        <!-- START SIDEBAR -->
        <div id="sidebar">
            <div id="searchbox" style="z-index: 880;">
                <div class="in" style="z-index: 870;">
                    <p class="text-center font18 line-height35">此广告位常年招商</p>
                </div>
            </div>
            <!-- start sidemenu -->
            <div id="sidemenu">
                <ul>
                    <li class="active"><a href="index.html"><img src="Public/Back/img/icons/sidemenu/laptop.png" width="16" height="16" alt="icon"/>控制面板</a></li>
                    <!-- 分类管理 -->
                    <li class="subtitle">
                        <a class="action tips-right" href="#" title="分类管理"><img src="Public/Back/img/icons/sidemenu/key.png" width="16" height="16" alt="icon"/>分类管理<img src="Public/Back/img/arrow-down.png" width="7" height="4" alt="arrow" class="arrow" /></a>
                        <ul class="submenu display-block">
                            <li><a href="categoryIndex.html"><img src="Public/Back/img/icons/sidemenu/file.png" width="16" height="16" alt="icon"/>分类列表</a></li>
                            <li><a href="categoryAdd.html"><img src="Public/Back/img/icons/sidemenu/file_add.png" width="16" height="16" alt="icon"/>添加分类</a></li>
                        </ul>
                    </li>
                    <!-- 分类管理 -->

                    <!-- 博文管理 -->
                    <li class="subtitle">
                        <a class="action tips-right" href="#" title="博文管理"><img src="Public/Back/img/icons/sidemenu/mail.png" width="16" height="16" alt="icon"/>博文管理<img src="Public/Back/img/arrow-down.png" width="7" height="4" alt="arrow" class="arrow" /></a>
                        <ul class="submenu display-block">
                            <li><a href="articleAdd.html"><img src="Public/Back/img/icons/sidemenu/file_add.png" width="16" height="16" alt="icon"/>添加博文</a></li>
                            <li><a href="articleIndex.html"><img src="Public/Back/img/icons/sidemenu/file.png" width="16" height="16" alt="icon"/>博文列表</a></li>
                        </ul>
                    </li>
                    <!-- 博文管理 -->

                    <!-- 用户管理 -->
                    <li class="subtitle">
                        <a class="action tips-right" href="#" title="用户管理"><img src="Public/Back/img/icons/sidemenu/user.png" width="16" height="16" alt="icon"/>用户管理<img src="Public/Back/img/arrow-down.png" width="7" height="4" alt="arrow" class="arrow" /></a>
                        <ul class="submenu display-block">
                            <li><a href="userAdd.html"><img src="Public/Back/img/icons/sidemenu/user_add.png" width="16" height="16" alt="icon"/>添加用户</a></li>
                            <li><a href="userIndex.html"><img src="Public/Back/img/icons/sidemenu/file.png" width="16" height="16" alt="icon"/>用户列表</a></li>
                        </ul>
                    </li>
                    <!-- 用户管理 -->

                    <!-- 评论管理 -->
                    <li><a href="commentIndex.html"><img src="Public/Back/img/icons/sidemenu/file.png" width="16" height="16" alt="icon"/>评论列表</a></li>
                    <!-- 评论管理 -->
                </ul>
            </div>
            <!-- end sidemenu -->
        </div>
        <!-- END SIDEBAR -->

        <!-- START PAGE -->
        <div id="page">
            <!-- start page title -->
            <div class="page-title">
                <div class="in">
                    <div class="titlebar">	<h2>分类管理</h2>	<p>分类列表</p></div>

                    <div class="clear"></div>
                </div>
            </div>
            <!-- end page title -->

            <!-- START CONTENT -->
            <div class="content">
                <!-- START TABLE -->
                <div class="simplebox grid740">

                    <div class="titleh">
                        <h3>分类列表</h3>
                    </div>

                    <table id="myTable" class="tablesorter">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th>名称</th>
                            <th>下属博文数量</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
                            <td><?php echo str_repeat('----',$_smarty_tpl->tpl_vars['v']->value['level']);
echo $_smarty_tpl->tpl_vars['v']->value['c_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['c_parent_id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['c_sort'];?>
</td>
                            <td>
                                <a href="index.php?p=Back&m=Category&a=edit&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">编辑</a>
                                <a href="index.php?p=Back&m=Category&a=delete&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"
                                onClick="return confirm('确定删除分类<?php echo $_smarty_tpl->tpl_vars['v']->value['c_name'];?>
');"
                                >删除</a>
                            </td>
                        </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                    </table>
                </div>
                <!-- END TABLE -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END PAGE -->
        <div class="clear"></div>
    </div>
    <!-- END MAIN -->

    <!-- START FOOTER -->
    <div id="footer">
        <div class="left-column">© Copyright 2016 - 保留所有权利.</div>
    </div>
    <!-- END FOOTER -->
</div>
</body>
</html><?php }
}
