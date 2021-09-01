<?php
    include('_header.php');
    $place_sections=array();
    $getSections=$db->get_allrow('sections', array('status' => 1, 'lang_code' => $_['code']));
    foreach ($getSections as $Section) {
        $place_sections[$Section['position']][]=array(
            'position' => $Section['position'],
            'title' => $Section['title'],
            'content' => $Section['content'],
        );
    }
?>
<!-- Rev Slider -->
<section id="slider" class="contain">

    <div class="tp-banner">
        <ul>
            <?php
            $getslides=$db->get_allrow('slides', array('status' => '1', "lang_code" => $_['code']), 'order', 'ASC');
                foreach ($getslides as $slide) {
            ?>
            <!-- Slide -->
            <li class="revslide" data-transition="random" data-slotamount="7" data-masterspeed="800">
                <!-- MAIN IMAGE -->
                <img src="<?=upload_url('slides/'.$slide['image'])?>" alt="slidebg2" data-bgfit="cover"
                    data-bgposition="left top" data-bgrepeat="no-repeat">
                <!-- LAYERS -->

                <? if (!empty($slide['title'])) {?>
                <!-- Layer 1 -->
                <div class="tp-caption sft customout" data-x="center" data-y="220"
                    data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                    data-speed="900" data-start="1400" data-easing="Power4.easeOut" data-endspeed="500"
                    data-endeasing="Power4.easeIn" data-captionhidden="on">
                    <h4 class="stext h4"><?=$slide['title']?></h4>
                </div>
                <? } ?>

                <? if (!empty($slide['text'])) {?>
                <!-- Layer 2 -->
                <div class="tp-caption sfb customout" data-x="center" data-y="320"
                    data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                    data-speed="900" data-start="1700" data-easing="Power4.easeOut" data-endspeed="500"
                    data-endeasing="Power4.easeIn" data-captionhidden="on">
                    <h5 class="stext h5"><?=$slide['text']?></h5>
                </div>
                <? } ?>
            </li>
            <? } ?>
        </ul>
    </div>
</section>
<!-- End Rev Slider -->

<? if (!empty(getOption('telegram_username'))) { ?>
<!-- Text Area -->
<section id="text-area">
    <div class="inner text-area">
        <h1><?=$_['text_under_slide']?></h1>
        <a href="https://t.me/<?=getOption('telegram_username')?>" target="_blank" class="button">
            <?=$_['join_channel_now']?>
        </a>
    </div>
</section>
<? } ?>
<!-- End Rev Slider -->

<!-- About Section -->
<section id="about" class="contain nav-link">

    <div class="about inner">

        <!-- First Content -->
        <div class="about-content animated" data-animation="flipInY" data-animation-delay="0">

            <div class="icon top">
                <i class="fa fa-check-circle-o "></i>
            </div>

            <div class="content-header text"><?=$_['forex_signals']?></div>
            <div class="content-desc text"><?=$_['forex_signals_text']?></div>

            <div class="icon bottom">
                <i class="fa fa-plus "></i>
            </div>

        </div>

        <!-- Second Content -->
        <div class="about-content animated" data-animation="flipInY" data-animation-delay="100">

            <div class="icon top">
                <i class="fa fa-check-circle-o "></i>
            </div>

            <div class="content-header text"><?=$_['gold_signals']?></div>
            <div class="content-desc text"><?=$_['gold_signals_text']?></div>

            <div class="icon bottom">
                <i class="fa fa-plus "></i>
            </div>

        </div>

        <!-- Third Content -->
        <div class="about-content animated" data-animation="flipInY" data-animation-delay="200">

            <div class="icon top">
                <i class="fa fa-check-circle-o "></i>
            </div>

            <div class="content-header text"><?=$_['crypto_signals']?></div>
            <div class="content-desc text"><?=$_['crypto_signals_text']?></div>

            <div class="icon bottom">
                <i class="fa fa-plus "></i>
            </div>

        </div>

        <!-- Fourth Content -->
        <div class="about-content animated" data-animation="flipInY" data-animation-delay="300">

            <div class="icon top">
                <i class="fa fa-check-circle-o "></i>
            </div>

            <div class="content-header text"><?=$_['pair_bomber_EA']?></div>
            <div class="content-desc text"><?=$_['pair_bomber_EA_text']?></div>
            <div class="icon bottom">
                <i class="fa fa-plus "></i>
            </div>

        </div>

        <div class="clear"></div>
        <hr class="skills">
    </div><!-- End Inner div -->

</section><!-- End About Section -->

<!-- Our Team Section -->
<section id="reviews" class="contain nav-link">

    <div class="inner">

        <!-- Header -->
        <div class="header ">
            <?=$_['what_the_say_about_us']?>
            <br>
            <br>
        </div>
        <div class="team-items slide-boxes">
            <? 
            $getUsersays=$db->get_allrow("user_says", "no", "order", "ASC");
            foreach ($getUsersays as $says) {
        ?>
            <div class="item animated" data-animation="flipInY" data-animation-delay="0">
                <h3><?=$says['name']?></h3>
                <h4><?=$countries[$says['country']]?></h4>
                <p><?=htmlspecialchars(strip_tags($says['text']))?></p>
            </div>
            <? } ?>
        </div>
        <hr class="skills">
    </div><!-- End inner div -->

</section><!-- End Our Team Section -->

<section id="statements" class="contain nav-link">

    <div class="inner">


        <!-- Header -->
        <div class="header">
            <?=$_['our_awesome_results']?>
            <br>
            <?
                $findUser['id']='';
                if (isset($_COOKIE['login_hash'])) {
                    $findUser=$db->get_onerow('users', array('login_hash' => escape_string($_COOKIE['login_hash'])));
                    if (!empty($findUser['id'])) {
                        echo '<p style="font-size: 20px;">'.$_['hi'].' '.$findUser['fullname'].' <small style="font-size: 15px;"><a href="'.action_url(array('act' => 'logout')).'" onclick="return confirm(\''.$_['are_you_sure'].'\');">('.$_['logout'].')</a></small></p>';
                        echo '<p style="font-size: 15px;">'.$findUser['email'].'</p>';
                    }
                }
            ?>
            <br>
        </div>
        

        <div class="works">
            <?
            if (!empty($findUser['id'])) {
                echo '<div class="items ">';
                $add_where=getOption('results_show_all_language')=='1'?array("lang_code" => $_['code']):'no';
                $getResults=$db->get_allrow('results', $add_where, 'order', 'ASC');
                foreach ($getResults as $result) {
            ?>
            
                <div class="work col-xs-4 web photography">
                    <div class="work-inner">
                        <div class="work-img">
                            <img src="<?=upload_url('results/'.$result['image'])?>" alt=""/>
                            <div class="mask">
                                <a class="button zoom" href="<?=base_url('results?hash='.$result['hash'])?>" target="_blank"><i class="fa fa-search"></i></a>
                                <!-- <a class="button detail"><i class="fa fa-anchor"></i></a> -->
                            </div>
                        </div>
                        <div class="work-desc">
                            <h4>Forex results</h4>
                        </div>
                    </div>
                </div>
            <?
                }
            echo '</div>';
            }else {
            ?>
            <div class="items ">
                <div class="work col-xs-12">
                    <div class="work-inner">
                        <div class="work-desc">
                            <h4><?=$_['results_login_about']?></h4>
                        </div>
                    </div>
                </div>
                <div class="work col-xs-12">
                    <div class="work-inner">
                        <div class="work-desc">
                            <h4><button onclick="return $('#login-register-form').modal({ backdrop: 'static',keyboard: false});"
                                    class="btn btn-success w-full btn-lg"
                                    style="width: 100%;"><?=$_['login_register_button']?></button></h4>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <? } ?>

        </div>
    </div>

</section>


<!-- Login / Register Modal-->
<div class="modal fade" id="login-register-form" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span class="fa fa-remove"></span>
                </button>
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#login-form"> <?=$_['login']?> <span class="fa fa-user"></span></a></li>
                    <li class="active"><a data-toggle="tab" href="#registration-form"> <?=$_['register']?> <span class="fa fa-pencil"></span></a></li>
                    <li><a data-toggle="tab" href="#recovery-form"> <?=$_['recover_password']?> <span class="fa fa-history"></span></a></li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div id="recovery-form" class="tab-pane fade">
                        <div class="recover-class">
                            <sform action="<?=action_url(array('form' => 'recover'))?>" method="POST" id="recover_form">
                                <div class="form-group">
                                    <label><?=$_['email']?>:</label>
                                    <input type="email" class="form-control" name="email" required="required">
                                </div>
                                <button type="submit" onclick="return ajaxForm('recover_form');" class="btn btn-primary btn-full"><?=$_['submit']?></button>
                            </sform>
                        </div>
                    </div>
                    <div id="login-form" class="tab-pane fade">
                        <div class="login-class">
                            <sform action="<?=action_url(array('form' => 'login'))?>" method="POST" id="login_form">
                            <div class="form-group">
                                <p id="add_area" class="btn-danger"></p>
                            </div>
                            <div class="form-group">
                                <label><?=$_['email']?>:</label>
                                <input type="email" class="form-control" name="email" required="required">
                            </div>
                            <div class="form-group">
                                <label><?=$_['password']?>:</label>
                                <input type="password" class="form-control" name="password" required="required">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" checked> <?=$_['remember_me']?></label>
                            </div>
                            <button type="submit" onclick="return ajaxForm('login_form');" class="btn btn-primary btn-full"><?=$_['login']?></button>
                        </sform>
                        </div>
                    </div>
                    <div id="registration-form" class="tab-pane fade in active">
                        <div class="register-class">
                            <sform action="<?=action_url(array('form' => 'register'))?>" method="POST" id="register_form">
                            <div class="form-group">
                                <label><?=$_['fullname']?>*:</label>
                                <input type="text" class="form-control" name="fullname" required="required">
                            </div>
                            <div class="form-group">
                                <label><?=$_['country']?>*:</label>
                                <select class="form-control" name="country" required="required">
                                    <option value="" disabled selected>-- <?=$_['please_select']?> --</option>
                                    <? 
                                        foreach ($countries as $code => $country) {
                                            echo '<option value="'.$code.'">'.$country.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?=$_['telegram_username']?>*:</label>
                                <input type="text" class="form-control" placeholder="@username" name="telegram_username" required="required">
                            </div>
                            <div class="form-group">
                                <label><?=$_['whatsapp_no']?>*:</label>
                                <input type="text" class="form-control" placeholder="+1 535 2354510" name="whatsapp_no" required="required">
                            </div>
                            <div class="form-group">
                                <label><?=$_['email']?>*:</label>
                                <input type="email" class="form-control" name="email" required="required">
                            </div>
                            <div class="form-group">
                                <label><?=$_['password']?>*:</label>
                                <input type="password" class="form-control" name="password" required="required">
                            </div>
                            <button onclick="return ajaxForm('register_form');" type="submit" class="btn btn-primary btn-full"><?=$_['register']?></button>
                        </sform>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Skills Section -->
<section id="services" class="contain nav-link">

    <div class="inner skills">

        <!-- Header -->
        <div class="header ">
            <?=$_['what_we_offer']?>
            <br>
            <br>
        </div>
        <br>
        <br>

        <!-- Tabs -->
        <div class="tabs">
            <?php
                $getWhat_offer=$db->get_allrow('what_offer', array("lang_code" => $_['code']), 'order', 'ASC')
            ?>
            <!-- Nav Menu -->
            <ul class="nav nav-tabs" id="tab-menu">
                <? foreach ($getWhat_offer as $key => $offer) { ?>
                <li <?=($key==0?'class="active"':'')?>><a href="#offer<?=$key?>"
                        data-toggle="tab"><?=$offer['title']?></a></li>
                <? } ?>
            </ul>

            <div class="tab-content">
                <? foreach ($getWhat_offer as $key => $offer) { ?>
                <div class="tab-pane fade <?=($key==0?'in active':'')?>" id="offer<?=$key?>">
                    <div class="tab-desc only">
                        <?=$offer['text']?>
                    </div>
                    <div class="clear"></div>
                </div>
                <? } ?>

            </div><!-- End tab-content div -->

        </div><!-- End Tabs div -->


        <!-- Skills -->
        <div class="Progress-bars">

            <div class="head"><?=$_['our_skills']?></div>

            <div class="Progress-content">
            <?php
            $getSkills=$db->get_allrow('skills', array("lang_code" => $_['code']), 'order', 'ASC');
                foreach ($getSkills as $skill) {
            ?>
                <div class="progress-bars">
                    <!-- Progress Texts -->
                    <div class="progress-texts">
                        <span class="progress-name"><?=$skill['title']?></span>
                        <span class="progress-value"><?=$skill['percent']?>%</span>
                        <div class="clear"></div>
                    </div>
                    <!-- Progress Tables -->
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="45"
                            aria-valuemin="0" aria-valuemax="100" style="width: <?=$skill['percent']?>%"></div>
                    </div>
                </div>
                <? } ?>
            </div>

        </div>

        <div class="clear"></div>
        <hr class="skills">
    </div><!-- End Inner div -->

</section>
<!-- End Features Section -->


<section id="prices" class="contain ">

    <div class="inner prices">

        <!-- Header -->
        <div class="header ">
            <?=$_['price_packages']?>
            <br>
            <br>
        </div>

        <div class="packages">
            <?php
            $getPackages=$db->get_allrow('packages', array("lang_code" => $_['code']), 'order', 'ASC');
                foreach ($getPackages as $key => $package) {
            ?>
            <!-- First Package -->
            <div class="package <?=$key==3?'active':'last';?> animated" data-animation="flipInY" data-animation-delay="100">
                <!-- Package Header -->
                <h1><?=$package['title']?></h1>
                <!-- Package Price -->
                <div class="circle">
                    <h2>$<?=$package['price'] >= 100?$package['price']:"{$package['price']} <span>.00</span>";?></h2>
                    <p><?=$package['period']?></p>
                </div>
                <!-- Package Properties -->
                <ol>
                    <?php
                        $lidecode=json_decode($package['detalis'], TRUE);
                        foreach ($lidecode as $li) {
                            echo '<li>'.$li.'</li>';
                        }
                    ?>
                </ol>
                <!-- Package Button -->
                <a class="p-btn" onclick="return $('#buybtform<?=$key?>').submit();">Buy Now</a>
                
                <form action="https://pay.skrill.com" id="buybtform<?=$key?>" method="post" target="_blank">
                <input type="hidden" name="pay_to_email" value="usd.premiumfxsignals@gmail.com">
                <input type="hidden" name="status_url" value="mckinlysteven@gmail.com">
                <input type="hidden" name="language" value="EN">
                <input type="hidden" name="amount" value="<?=$package['price']?>">
                <input type="hidden" name="currency" value="USD">
                <input type="hidden" name="detail1_description" value="Description:">
                <input type="hidden" name="detail1_text" value="<?=$package['title']?>">
                <input type="hidden" id="buybtn<?=$key?>" value="Buy now">
                </form>
            </div>
            <? } ?>

            <div class="clear"></div>
        </div><!-- End Packages -->
        <hr class="skills">
    </div><!-- End inner div -->
</section><!-- End Prices Section -->

<!-- Download e-book -->
<section id="reviews" class="contain nav-link">
    <div class="inner">
        <!-- Header -->
        <div class="header ">
            <?=$_['download_e-book']?>
            <br>
            <br>
        </div>
        <div class="works">
            <sform action="<?=action_url(array('form' => 'download_request'))?>" method="POST" id="download_form">
                <div class="row">
                    <div class="col-md-6">
                        <img src="<?=upload_url('book.jpg')?>" style="height: 250px;width: 250px;" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?=$_['fullname']?>*:</label>
                                <input type="text" class="form-control" name="fullname" required="required">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?=$_['email']?>*:</label>
                                <input type="text" class="form-control" name="email" required="required">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><br/></label>
                                <input type="button" onclick="return ajaxForm('download_form');" class="form-control btn btn-primary" value="<?=$_['download']?>">
                            </div>
                        </div>
                    </div>
                </div>
            </sform>
        </div>
        <hr class="skills">
    </div><!-- End inner div -->
</section><!-- End Download e-book -->

<? foreach ($place_sections['download_ebook_bottom'] as $place) { ?>
<!-- Download e-book -->
<section id="reviews" class="contain nav-link">
    <div class="inner">
        <!-- Header -->
        <div class="header ">
            <?=$place['title']?>
            <br>
            <br>
        </div>
        <div class="tab-desc only">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?=upload_url('free_section.jpg')?>" style="height: 250px;width: 250px;" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <p><?=$place['content']?></p>
                </div>
            </div>
        </div>
        <hr class="skills">
    </div><!-- End inner div -->
</section><!-- End Download e-book -->
<? } ?>

<section id="faq" class="contain parallax">

    <div class="inner">
        <!-- Header -->
        <div class="header ">
            <?=$_['faq']?>
            <br>
            <br>
        </div>
        <!-- Iphone images -->
        <div class="w-iphone animated" data-animation="fadeInLeft" data-animation-delay="0">
            <img src="<?=dist_url('user/')?>images/FAQ.png" alt="wisten-iphone">
        </div>

        <!-- accordion menu -->
        <div class="accordion" id="accordion2">
            <? 
            $getFAQ=$db->get_allrow("faq", array("lang_code" => $_['code']), "order", "ASC");
            foreach ($getFAQ as $key => $FAQ) {
        ?>
            <!-- accordion menu 1 -->
            <div class="panel">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#coll-<?=$key?>">

                        <i class="fa fa-check"></i>
                        <?=strip_tags($FAQ['title'])?>
                    </a>
                </div>
                <div id="coll-<?=$key?>" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <?=strip_tags($FAQ['text'])?>
                    </div>
                </div>
            </div>
            <? } ?>
        </div>


        <div class="clear"></div>
    </div>

</section>

<section id="contact" class="contain nav-link" style="background-color: #F9f9f8;">
    <div class="inner">
        <!-- Header -->
        <div class="header">
            <?=$_['contact']?>
            <br>
            <br>
        </div>
        <div class="works">
            <div class="items ">
                <div class="work col-xs-12">
                    <div class="work-inner" id="contact-form">
                        <div class="work-desc" style="background-color: #F9f9f8 !important;">
                            <sform action="<?=action_url(array('form' => 'contact'))?>" method="POST" id="contact_form">
                                <div class="form-group">
                                    <label><?=$_['fullname']?>*:</label>
                                    <input type="text" class="form-control" name="fullname" required="required">
                                </div>
                                <div class="form-group">
                                    <label><?=$_['email']?>*:</label>
                                    <input type="email" class="form-control" name="email" required="required">
                                </div>
                                <div class="form-group">
                                    <label><?=$_['subject']?>*:</label>
                                    <input type="text" class="form-control" name="subject" required="required" maxlength="100" id="c_subject">
                                </div>
                                <div class="form-group">
                                    <label><?=$_['message']?>*:</label>
                                    <textarea class="form-control" name="message" required="required" rows="3" maxlength="350"></textarea>
                                </div>
                                <button onclick="return ajaxForm('contact_form');" type="submit" class="btn btn-primary btn-full"><?=$_['submit']?></button>
                            </sform>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</section>
<?php
    include('_footer.php');
?>