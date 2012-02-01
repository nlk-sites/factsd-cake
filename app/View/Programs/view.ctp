
                <div class="main_txt">
                    <?php echo $this->Html->link('Back to Search Results', array('controller' => 'programs', 'action' => 'index'), array('class' => 'btn_back'));?>
                    <h1><?php echo $program['Program']['name'];?></h1>
                    <div class="txt_box">
                        <p><strong>Umbrella Agency:</strong> <?php echo $program['Agency']['name'];?></p>
                        <p><strong>Program Name:</strong> <?php echo $program['Program']['name'];?></p>
                        <p>
                            <?php if($program['Program']['clients_only'] == 1){?>
                                <strong>Transportation for clients only</strong><br />
                            <?php }?>
                            <?php if($program['Program']['advance_reservation'] == 1){?>
                                <strong>Advance Reservations Required:</strong> <?php echo $program['Program']['reservation_days'];?>
                            <?php }?>
                        </p>
                        <?php if(!empty($program['Program']['description'])){?>
                            <p><?php echo $program['Program']['description'];?></p>
                        <?php }?>
                    </div>

                    <?php if(isset($program['Service']) && !empty($program['Service'])){?>
                        <div class="txt_box">
                            <h2>Program Services</h2>
                            <ul class="txt_list">
                                <?php foreach($program['Service'] as $s){?>
                                    <li><?php echo $s['name'];?></li>
                                <?php }?>
                            </ul>
                        </div>
                    <?php }?>

                    <div class="txt_box">
                        <h2>Eligibility Requirements</h2>
                        <?php if(isset($program['EligReqOption']) && !empty($program['EligReqOption'])){?>
                            <ul class="txt_list">
                                <?php foreach($program['EligReqOption'] as $e){
                                    if(in_array(strtolower($e['name']), array('yes', ''))){?>
                                        <li><?php echo $e['EligReq']['name'];?></li>
                                    <?php }else{?>
                                        <li><?php echo $e['EligReq']['name'].': '.$e['name'];?></li>
                                    <?php }?>
                                <?php }?>
                            </ul>
                        <?php }else{ ?>
                            <p>We do not have any information about this agency's eligibility requirements.<br />Please call or email '.$program['Agency']['name'].' for more information.</p>
                        <?php }?>
                    </div>
                    <?php if(isset($program['Fee']) && !empty($program['Fee'])){?>
                        <div class="txt_box txt_box_last">
                            <h2>Program Fees</h2>
                            <ul class="txt_list">
                                <?php foreach($program['Fee'] as $f){?>
                                <li>
                                    <strong>
                                    <?php switch($f['fee_type_id']){
                                        case 1:
                                            echo 'Flat fare each way: $'.number_format($f['fee'], 2);
                                            break;
                                        case 2:
                                            echo 'Flat fare round trip: $'.number_format($f['fee'], 2);
                                            break;
                                        case 3:
                                            echo '$'.number_format($f['fee'], 2).' per hour';
                                            break;
                                        case 4:
                                            echo '$'.number_format($f['fee'], 2).' per day';
                                            break;
                                        case 5:
                                            echo '$'.number_format($f['fee'], 2).' per month';
                                            break;
                                        case 6:
                                            echo '$'.number_format($f['fee'], 2).' per year';
                                            break;
                                        case 7:
                                            echo 'Wait time: $'.number_format($f['fee'], 2).' per hour';
                                            break;
                                        case 8:
                                            echo '';
                                            if(!empty($f['fee']) && $f['fee'] != 0){
                                                echo '$'.number_format($f['fee'], 2);
                                                if(!empty($f['miles_included'])){
                                                    echo ' for the first '.$f['miles_included'].' miles, and then ';
                                                }else{
                                                    echo ' flat fee plus ';
                                                }
                                            }
                                            if(!empty($f['per_mile']) && $f['per_mile'] != 0){
                                                echo '$'.number_format($f['per_mile'], 2).' per mile';
                                            }
                                            break;
                                        case 9:
                                            echo 'No Fee';
                                            break;
                                        case 10:
                                            if(empty($f['misc_fee']) || $f['misc_fee'] == $f['description']){
                                                $f['misc_fee'] = $f['description'];
                                                $f['description'] = '';
                                            }
                                            echo $f['misc_fee'];
                                            break;
                                    }
                                    if(!empty($f['description']))echo ', ';
                                    ?>
                                    </strong>
                                    <?php echo $f['description'];?>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    <?php }?>
                </div><!--end of main_txt-->
                <div class="contact_box">
                    <?php if(!empty($program['Program']['phone'])){
                        $contact[] = '<p><strong>Phone:</strong> '.$program['Program']['phone'].'</p>';
                    }
                    if(!empty($program['Program']['email'])){
                        $contact[] = '<p><strong>Email:</strong> <a href="mailto:'.$program['Program']['email'].'">'.$program['Program']['email'].'</a></p>';
                    }
                    if(!empty($program['Program']['url'])){
                        $contact[] = '<a class="btn_visit" href="'.(substr($program['Program']['url'], 0, 4) == 'http' ? '' : 'http://') . $program['Program']['url'].'">visit website</a>';
                    }
                    if(isset($contact)){
                        echo '<div class="contact_title">Contact</div>';
                        echo implode('', $contact);
                    }?>
                    <div class="contact_title contact_title_open_hours">Open Hours</div>
                    <?php foreach(array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day){
                        echo '<p><b>'.ucfirst($day).':</b> '.$program['Program']['open_hours_'.$day].'</p>';
                    }?>
                </div>
                <div class="review_box">
                    <?php if(isset($program['Review']) && !empty($program['Review'])){?>
                        <div class="cont_title">Review</div>
                        <?php foreach($program['Review'] as $r){?>
                            <div class="single_review">
                                <p><?php echo strip_tags($r['review']);?></p>
                                <p class="review_author"><span>Posted by: <?php echo strip_tags($r['name']);?></span> | <span><?php echo date('F j, Y \a\t g:i A', strtotime($r['created']));?></span></p>
                            </div>
                        <?php }
                    }?>
                    <?php echo $this->element('add_reviews');?>
                </div><!--end of review_box-->