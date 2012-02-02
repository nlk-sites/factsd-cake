<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="height:100%">
<head>
<title>FACT Administration -- <?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<?php echo $this->Html->css('main');?>
<?php echo $this->Html->css('baseAdmin');?>
<?php echo $this->Html->script('jquery-1.7.1.min');?>
<?php //echo $html->css('calendar-system');?>
<?php //echo $this->Html->css('wazzel');?>
<?php //echo $javascript->link('prototype');?>
<?php //echo $javascript->link('scriptaculous/src/scriptaculous');?>
<?php //echo $javascript->link('jsCalendar/calendar');?>
<?php //echo $javascript->link('jsCalendar/lang/calendar-en');?>
<?php //echo $javascript->link('jsCalendar/calendar-setup');?>
<!--<script type='text/javascript' 
        src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script>-->
</head>
<body style="min-width:700px">
<table id="frame" style="min-width:700px;border-spacing:0px;">
    <tr>
        <td id="header">
            <div id="banner" style="min-width:700px;">FACT Administration</div>
            <div id="navigation" style="min-width:700px;">
            <?php
                if($user_level < 1000){
                    $pages['agencies/edit'] = array('agencies', 'agency_aliases');
                }else{
                    $pages['agencies'] = array('agency_types', 'agency_aliases');
                }
                $pages['programs'] = array('fees');
                if($user_level >= 1000){
                    $pages = array_merge($pages, array('elig_reqs' => array(),'services' => array(),'zip_aliases'=>array('zip_aliases', 'zip_alias_types', 'regions'), 'reviews' => array()));
                }
                if($user_level >= 2000){
                    $pages['admins'] = array();
                }else{
                    $pages['admins/edit'] = array('admins');
                }
                
                foreach($pages as $page => &$assoc){
                    $class = array();
                    if($page=='admins'){
                        $title='Users';
                    }elseif($page=='elig_reqs'){
                        $title='Eligibility';
                    }elseif($page=='agencies/edit'){
                        $title = 'Agency';
                    }elseif($page == 'admins/edit'){
                        $title = 'My Account';
                    }else $title=ucwords(str_replace('_', ' ', $page));
                    $contName=$this->params['controller'];
                    if($page == 'reviews' && isset($new_reviews)){
                        $class[] = 'menu_highlight';
                    }elseif($page == 'zip_aliases' && isset($problem_zip_aliases) && !empty($problem_zip_aliases)){
                        $class[] = 'menu_highlight';
                        $page = 'zip_aliases/index/1';
                    }
                    if($contName==$page || in_array($contName, $assoc)){
                        $class[] = 'menu_active';
                    }
                    $assoc = $this->Html->link($title, '/admin/'.$page, array('class' => implode(' ', $class)));
                }
                echo implode(' | ', $pages);
                ?>
            </div>
            <div id="logout"><?php echo $this->Session->read('Auth.User.first_name').' '.$this->Session->read('Auth.User.last_name');?> [<?php echo $this->Html->link('Logout', '/admins/logout');?>]</div>
        </td>
    </tr>
    <tr>
        <td id="middle">
            <table style="border-spacing:0px">
                <tr>
                    <?php if(isset($sidebar) && !empty($sidebar)){?>
                        <td id="sidebar" style="border-bottom:0px none;width:210px">
                            <?php echo $this->element('sidebar'); ?>
                        </td>
                    <?php }?>
                    <td id="content">
                        <?php if(isset($breadcrumbs)){?>
                            <div id="breadcrumbs">
                                <?php 
                                if(count($breadcrumbs) > 1){
                                    foreach($breadcrumbs as $path => $crumb){
                                        if(!empty($path)){
                                            echo $this->Html->link($crumb, $path).' > ';
                                        }else{
                                            echo $crumb;
                                        }
                                    }
                                }
                                ?>
                                <h2><?php echo end($breadcrumbs);?></h2>
                            </div>
                        <?php }?>
                        <?php
                            if ($this->Session->check('Message.flash')) {
                                echo('<br style="line-height:5px"/>');
                                echo $this->Session->flash();
                                echo('<br style="line-height:5px"/>');
                            }
                        ?>
                        <?php echo $content_for_layout ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td id="footer">
            &#169; <?php echo date('Y');?> FACT. All rights reserved.
        </td>
    </tr>
</table>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>