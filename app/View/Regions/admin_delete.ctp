<div class="regions delete">
    <?php if(!empty($zip_regions['ZipAlias'])){?>
        <h4>Zip Aliases</h4>
        <table class="list">
            <tr>
                <th>Zip Alias</th>
                <th class="actions"><?php echo __('Actions');?></th>
            </tr>
            <?php
            $i = 1;
            foreach ($zip_regions['ZipAlias'] as $z): ?>
                <tr class="row-type-<?php echo $i++ % 2;?>">
                    <td><?php echo $z['name']; ?></td>
                    <td class="actions" nowrap>
                        <?php echo $this->Html->link(__('Edit Zip Alias'), array('controller' => 'zip_aliases', 'action' => 'edit', $z['id'], 'admin' => 1), array('target' => '_blank')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php }?>
    <?php if(!empty($zip_regions['Zip'])){?>
        <h4>Zipcodes</h4>
        <table class="list">
            <tr>
                <th>Zipcode</th>
                <th>Area Name</th>
            </tr>
            <?php
            $i = 1;
            foreach ($zip_regions['Zip'] as $z): ?>
                <tr class="row-type-<?php echo $i++ % 2;?>">
                    <td><?php echo $z['id']; ?></td>
                    <td><?php echo $z['area_name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php }?>
</div>