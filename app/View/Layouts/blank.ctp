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
<?php echo $content_for_layout; ?>
</body>
</html>