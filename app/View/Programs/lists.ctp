<div class="cont_holder">
    <div class="cont_head">
        <div class="cont_head_text">
            <div class="cont_title cont_title1">
                <span>Programs</span>
            </div>
            <h4>FACT is your source for information about public and private specialized transportation providers for seniors and people with disabilities.</h4>
        </div>
        <img src="http://fact.ninthlink.net/wp-content/themes/factsd/images/media/img1.jpg" width="603" height="276" alt=""/>
        <div class="ban_tag">
            <img src="http://fact.ninthlink.net/wp-content/themes/factsd/images/media/ban_ico2.png" width="154" height="193" alt="" />
        </div>
    </div><!--cont_head-->
    <?php if(!empty($open_programs)){?>
        <div class="list_cont">
            <div class="cont_title cont_title2">
                <span>Transportation Services for the General Public</span>
            </div>
            <?php $num_rows = ceil(count($open_programs)/3);
            foreach($open_programs as $i => $o){
                if(($i % $num_rows) == 0){?>
                    </ul>
                    <ul class="col<?php echo ceil($i % 3);?> col">
                <?php }?>
                <li><?php echo $this->Html->link($o['Program']['name'], array('action' => 'view', $o['Program']['slug']));?></li>
            <?php }?>                   
        </div><!---list_cont-->
    <?php }?>
        <?php if(!empty($closed_programs)){?>
        <div class="list_cont">
            <div class="cont_title cont_title2">
                <span>Transportation Services are Only for Individuals Enrolled in the Program</span>
            </div>
            <?php $num_rows = ceil(count($closed_programs)/3);
            foreach($closed_programs as $i => $o){
                if(($i % $num_rows) == 0){?>
                    </ul>
                    <ul class="col<?php echo ceil($i % 3);?> col">
                <?php }?>
                <li><?php echo $this->Html->link($o['Program']['name'], array('action' => 'view', $o['Program']['slug']));?></li>
            <?php }?>
            </ul>
        </div><!---list_cont-->
    <?php }?>
</div><!--end of cont_holder-->