<h1 style="margin-bottom: 0;"><?php if(strlen($sidebar['name']) > 24){
    echo trim(substr($sidebar['name'], 0, 23)).(strlen($sidebar['name']) > 23 ? '...' : '');
}else echo $sidebar['name'];?></h1>
<div class="actions">
    <ul>
        <?php
        foreach($sidebar['pages'] as $p_name => $p_info){
            $title = $this->Html->link($p_name, $p_info['link_data']);
            $sub = array();
            if($this->params['controller'] == $p_info['link_data']['controller'] && $this->action == $p_info['link_data']['action'] && (!isset($p_info['second_param']) || $p_info['second_param'] == $this->params['pass'][1])){
                $title = $p_name;
            }
            if(isset($p_info['subpages'])){
                foreach($p_info['subpages'] as $s_name => $s_info){
                    if($this->params['controller'] == $s_info['link_data']['controller'] && $this->action == $s_info['link_data']['action']){
                        $sub[] = $s_name;
                    }else{
                        $sub[] = $this->Html->link($s_name, $s_info['link_data']);
                    }
                }
            }?>
            <li>
                <?php echo $title;?>
                <?php if(!empty($sub)){?>
                    <ul><li><?php echo implode('</li><li>', $sub);?></li></ul>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>