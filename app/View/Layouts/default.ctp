<!doctype html>

<head>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php echo $this->Html->charset(); ?>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="MSSmartTagsPreventParsing" content="true" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="robots" content="index, follow" />
    <?php echo $this->Html->script('jquery-1.7.1.min');?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <?php echo $this->Html->css('screen');?>
    <?php echo $scripts_for_layout;?>

    <script type="text/javascript">
        $(document).ready( function(){
            $('.input_txt').each(function() {
                $('.input_txt').focus(function() {
                    $(this).val("").unbind("focus");
                });
            });

        });
    </script>

</head>

<body>
    <div class="top_bar">
        <div class="top_bar_inside">
            <span class="alerts_title">ALERTS</span>
            <p>As of October 5th 2011, FACT will no longer operate RideFACT in Ramona.Please contact NCTD's FLEX service to schedule your ride.… <a href="#">Read Alerts</a></p>
        </div>
    </div><!--end of top_bar-->

    <div id="header">
        <div class="logo"><a href="<?php echo $this->Html->url('/');?>"><?php echo $this->Html->image('logo.png');?></a></div>
        <div class="fonts_box">
            <a href="#" class="ico_font1">A</a>
            <a href="#" class="ico_font2">A</a>
            <a href="#" class="ico_font3">A</a>
            <span>Font Size</span>
        </div><!--end of fonts_box-->
    </div><!--end of header-->


    <div id="content">
        <div class="nav_box">
            <ul class="nav">
                <li class="on"><?php echo $this->Html->link('Home', '/');?></li>
                <li><?php echo $this->Html->link('Programs', '/programs');?></li>
                <li><?php echo $this->Html->link('Resources', '/resources.html');?></li>
                <li><a href="#">About Us </a></li>
                <li><a href="#">Meetings</a></li>
                <li class="last"><a href="#">Contact Us</a></li>
            </ul>
            <form action="search_result.html" class="search_form">
                <fieldset>
                    <input type="text" value="Search" class="input_txt" />
                    <input type="submit" value="" class="input_submit" />
                </fieldset>
                            </form>
        </div>
        <?php if($this->params['controller'] == 'pages' && $this->action == 'display' && $page == 'home'){?>
            <div class="find_box">
                <div class="find_title"><div>FIND <span>A</span> RIDE</div> <em>Enter a ZIP, City, Address, Hospital, or Facility</em></div>
                <?php echo $this->Form->create('Program', array('id' => 'ProgramIndexForm', 'class' => 'find_form', 'url' => array('controller' => 'programs', 'action' => 'index')));?>
                <fieldset>
                    <?php echo $this->Form->input('Program.origin', array('class' => 'input_txt', 'label' => false, 'value' => 'Your pick up location')); ?>
                    <?php echo $this->Form->input('Program.destination', array('class' => 'input_txt', 'label' => false, 'value' => 'Going to')); ?>
                    <?php echo $this->Form->submit('FIND A RIDE', array('id' => 'submit_filters', 'class' => 'input_submit'));?>
                </fieldset>
                <?php echo $this->Form->end();?>

                <div class="call">Call Toll Free for Immediate Assistance <strong>(888) 924-3228</strong></div>
                <div class="find_link">
                    <?php echo $this->Html->link('Browse all Service Providers', array('controller' => 'programs', 'action' => 'index'), array('class' => 'btn_browse'));?>
                    <span>&nbsp;</span>
                    <a href="#">Need Help Planning Your Trip?</a>
                </div>
            </div>
        <?php }elseif(!($this->action == 'index' && $this->params['controller'] == 'programs')){?>
            <div class="find_box">
            <?php echo $this->Form->create('Program', array('id' => 'ProgramIndexForm', 'class' => 'find_form2', 'url' => array('controller' => 'programs', 'action' => 'index')));?>
                <fieldset>
                    <div class="find_title">FIND <span>A</span> RIDE</div>
                    <?php echo $this->Form->input('Program.origin', array('class' => 'input_txt', 'label' => false, 'value' => 'Your pick up location')); ?>
                    <?php echo $this->Form->input('Program.destination', array('class' => 'input_txt', 'label' => false, 'value' => 'Going to')); ?>
                    <?php echo $this->Form->submit('FIND A RIDE', array('id' => 'submit_filters', 'class' => 'input_submit'));?>
                </fieldset>
            <?php echo $this->Form->end();?>
                            <div class="call">Call Toll Free for Immediate Assistance <strong>(888) 924-3228</strong></div>
                            <div class="find_link">
                <?php echo $this->Html->link('Browse all Service Providers', array('controller' => 'programs', 'action' => 'index'), array('class' => 'btn_browse'));?>
                                    <span>&nbsp;</span>
                                    <a href="#">Need Help Planning Your Trip?</a>
                            </div>
                    </div><!--end of find_box-->
        <?php }?>
        <div class="cont_box">
            <?php echo $this->Session->flash(); ?>

            <?php echo $content_for_layout; ?>
        </div><!--end of cont_box-->

    </div><!--end of content-->

    <div id="footer">
        <div class="footer_row1">
            <div class="footer_block">
                <div class="footer_title">ABOUT US</div>
                <ul class="footer_list">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">The Board</a></li>
                    <li><a href="#">CTSA / CAM Meetings</a></li>
                    <li><a href="#">History</a></li>
                    <li><a href="#">Jobs / Bids</a></li>
                </ul>
            </div>

            <div class="footer_block">
                <div class="footer_title">RESOURCES</div>
                <ul class="footer_list">
                    <li><a href="#">Search</a></li>
                    <li><a href="#">Alerts</a></li>
                    <li><a href="#">ADA ParaTransit</a></li>
                    <li><a href="#">Useful Links</a></li>
                    <li><a href="#">Library</a></li>
                </ul>
            </div>

            <div class="footer_block">
                <div class="footer_title">SUPPORT</div>
                <ul class="footer_list">
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Give Feedback</a></li>
                    <li><a href="#">Get Involved</a></li>
                </ul>

                <p>Email: email@email.com<br>Toll Free: (888) 924-3228</p>
            </div>

            <div class="footer_block last_footer_block">
                <div class="footer_title">FOLLOW US</div>
                <form action="#" class="sign_form">
                    <fieldset>
                        <div class="sign_form_title">Newsletter Signup</div>
                        <input type="text" value="Your Name" class="input_txt">
                        <input type="text" value="Your Email" class="input_txt">
                        <input type="submit" value="submit" class="input_submit">
                    </fieldset>
                </form>

                <p>
                    <a href="#"><?php echo $this->Html->image('link_f.png');?></a>
                    <a href="#"><?php echo $this->Html->image('link_t.png');?></a>
                    <a href="#"><?php echo $this->Html->image('link_rss.png');?></a>
                </p>
            </div>
        </div><!--end of footer_row1-->

        <div class="footer_row2">
            <div class="copyright">&copy;2011 FACT  <span>ı</span>  all rights reserved</div>
            <div class="btn_contribute"><a href="#"><span>Contribute Today</span></a></div>
        </div><!--end of footer_row2-->
        <div class="logo_w3c"><?php echo $this->Html->image('logo_w3c.gif');?></div>
    </div><!--end of footer-->
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>