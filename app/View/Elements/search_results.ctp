<?php if(isset($reset_map)){?>
    <script>
    $(document).ready(function(){
        <?php foreach($locations as $zip_type => $zips){?>
            $('#Location<?php echo ucfirst($zip_type);?>').val("<?php echo (is_array($zips) ? implode(',', $zips) : $zips);?>");
        <?php }?>
        <?php foreach($addresses as $address_type => $address){
            if(is_array($address)){?>
                set_address_options('<?php echo ucfirst($address_type);?>', <?php echo json_encode($address);?>);
            <?php }?>
            $('#Address<?php echo ucfirst($address_type);?>').val("<?php echo (is_array($address) ? '' : $address);?>");
        <?php }?>
        calcRoute();
        <?php if(count(array_filter($addresses)) == 2){
            $route = 'http://maps.google.com/maps?f=d&saddr='.urlencode($addresses['origin']).'&mrt=loc&t=m&daddr='.urlencode($addresses['destination']);?>
            $('#map_route_link').show().attr('href', '<?php echo $route;?>');
            $('#map_pub_route_link').show().attr('href', '<?php echo $route;?>&dirflg=r');
        <?php }else{?>
            $('#map_route_link').attr('href', '#').hide();
            $('#map_pub_route_link').attr('href', '#').hide();
        <?php }?>
        <?php //$route = array('controller' => 'programs', 'action' => 'map_route', (is_array($addresses['origin']) ? '' : urlencode($addresses['origin'])), (is_array($addresses['destination']) ? '' : urlencode($addresses['destination'])));?>
        //$('#map_route_link').attr('href', '<?php //echo $this->Html->url($route);?>');
    });
    </script>
<?php }?>
<?php $this->Paginator->options(array(
    'update' => '#content_for_update',
    'evalScripts' => true
));?>

<div class="found_result">
    <div class="found_result_title">
        <?php if(empty($programs) || !empty($msgs)){?>
            <div style="font-size: 12px">
                <?php if (!empty($msgs)){?>
                    <p><?php echo implode('</p><p>', $msgs);?></p>
                    <p style="padding:10px 0;">You may also <?php echo $this->Html->link('see all service providers', '/programs');?> or call toll free for immediate assistance: <strong>(888) 924-3228</strong></p>
                <?php }else{?>
                    <p style="color:red;">No results found.  Please try a different inquiry above or select fewer filters.</p>
                    <p><?php echo $this->Html->link('See all service providers', '/programs');?> or call toll free for immediate assistance: <strong>(888) 924-3228</strong></p>
                <?php }?>
            </div>
        <?php }?>
        <?php if(!empty($programs)){?>
            <strong>Found :</strong> <?php echo $this->Paginator->counter(array('format' => __('{:count} results, showing {:start} - {:end}')));?>
        <?php }?>
    </div>
    <?php if(!empty($programs)){?>
        <div class="result_pager1">
            <?php
            echo $this->Paginator->prev('&nbsp;', array('class' => 'page_prev'), null, array('class' => 'page_prev disabled page_prev_disabled'));
            echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn_page', 'first' => 1, 'last' => 1, 'modulus' => 3, 'ellipsis' => '<span>...</span>'));
            echo $this->Paginator->next('&nbsp;', array('class' => 'page_next'), null, array('class' => 'page_next disabled page_next_disabled'));
            ?>
        </div>
    <?php }?>
</div><!--end of result_pager-->
<div class="search_result_box">
    <div class="search_result_title">
        <span>Agency / Program</span>
        <strong>Contact</strong>
    </div>
    <?php foreach ($programs as $program){ ?>
        <div class="search_result_row">
            <div class="result_title"><?php echo $this->Html->link($program['Program']['name'], array('action' => 'view', $program['Program']['slug'])); ?></div>
            <div class="result_txt1">
                <p>
                    <?php $description = strip_tags($program['Program']['description']);
                    echo h(substr($description, 0, 200));
                    if (strlen($description) > 200) {
                        echo '... ' . $this->Html->link('Read More', array('action' => 'view', $program['Program']['slug']));
                    } ?>
                </p>
            </div>
            <div class="result_txt2">
                <?php if (!empty($program['Program']['phone'])) { ?>
                        <p><strong>Phone:</strong> <?php echo $program['Program']['phone']; ?></p>
                    <?php } ?>
                    <?php if (!empty($program['Program']['url'])) { ?>
                        <p><strong>Website:</strong> <a href="<?php echo (substr($program['Program']['url'], 0, 4) == 'http' ? '' : 'http://') . $program['Program']['url']; ?>"><?php echo $program['Program']['url']; ?></a></p>
                    <?php } ?>
                    <?php if (!empty($program['Program']['email'])) { ?>
                        <p><strong>Email:</strong> <a href="mailto:<?php echo $program['Program']['email']; ?>"><?php echo $program['Program']['email']; ?></a></p>
                    <?php } ?>
            </div>
        </div><!--end of search_result_row-->
    <?php }?>
</div>
<?php if(!empty($programs)){?>
    <div class="result_pager2">
        <?php
        echo $this->Paginator->prev('Prev', array('class' => 'page_prev'), null, array('class' => 'page_prev disabled page_prev_disabled'));
        echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn_page', 'first' => 1, 'last' => 1, 'modulus' => 3, 'ellipsis' => '<span>...</span>'));
        echo $this->Paginator->next('Next', array('class' => 'page_next'), null, array('class' => 'page_next disabled page_next_disabled'));
        ?>
    </div><!--end of result_pager2-->
<?php }?>
<?php echo $this->Js->writeBuffer();?>