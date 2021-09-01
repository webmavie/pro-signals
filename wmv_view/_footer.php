<!-- Footer Section -->
<section id="footer">
	
    <div class="inner footer">
    
        <!-- Phone -->
        <div class="col-xs-3 animated footer-box" data-animation="flipInY" data-animation-delay="0">
            <a class="footer-links">
                <i class="fa fa-whatsapp" style="color:white"></i>
            </a>
            
            <p class="footer-text">
                <span>WhatsApp</span>:<span><a href="https://wa.me/<?=str_replace(array("+", " "), "", getOption('whatsapp_number'))?>"><?=getOption('whatsapp_number')?></a></span>
            </p>
        </div>
        
        <!-- Socials and Mail -->
        <div class="col-xs-3 animated footer-box" data-animation="flipInY" data-animation-delay="0">
            <!-- Icon -->
            <a class="footer-links">
                <i class="fa fa-telegram" style="color:white"></i>
            </a>
            
            <p class="footer-text">
                <a href="https://t.me/<?=getOption('telegram_username')?>">@<?=getOption('telegram_username')?>
            </a>
            </p>
            
        </div>
        
        <!-- Adress -->
        <div class="col-xs-3 animated footer-box" data-animation="flipInY" data-animation-delay="0">
        
            <!-- Icon -->
            <a class="footer-links">
                <i class="fa fa-map-marker" style="color:white"></i>
            </a>
            
            <p class="footer-text">
            <?=getOption('company_adress')?>
            </p>
        </div>

        <!-- Join newsletter -->
        <div class="col-xs-3 animated footer-box" data-animation="flipInY" data-animation-delay="0">
        
            <!-- Icon -->
            <a class="footer-links">
                <i class="fa fa-at" style="color:white"></i>
            </a>
            
            <p class="footer-text">
                <div class="stop-submit">
                    <sform action="<?=action_url(array('form' => 'join_newsletter'))?>" method="POST" id="newsletter_form">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" required="required" placeholder="<?=$_['email']?>">
                        </div>
                        <button onclick="return ajaxForm('newsletter_form');" type="submit" class="btn btn-primary btn-full"><?=$_['join_to_newsletter']?></button>
                    </sform>
                </div>
            </p>
        </div>
        
        <div class="clear"></div><br/>
        <p class="footer-text copyright">
        <span>&copy;<?=DATE('Y')?> <a href="<?=base_url()?>"><?=getOption('site_name')?></a>. </span><?=$_['all_rights_reserved']?></p>
    </div> <!-- End Footer inner -->
    
</section><!-- End Footer Section -->
<section>

</section id="copyright">
<!-- Back To Top Button -->
<section id="back-top">
    <a href="#home" class="scroll"></a>
</section>
<!-- End Back To Top Button -->

<!-- JS Files -->
<?php
	if (isset($_SESSION['alertback'])) {
		$alertback=json_decode($_SESSION['alertback']);
        if ($alertback->icon == 'success') {
            echo "<script>Notiflix.Report.Success(
                '',
                '".$alertback->title."',
                'OK'
            );</script>";
        }elseif ($alertback->icon == 'success') {
            echo "<script>Notiflix.Report.Warning(
                '',
                '".$alertback->title."',
                'OK'
            );</script>";
        }elseif ($alertback->icon == 'info') {
            echo "<script>Notiflix.Report.Info(
                '',
                '".$alertback->title."',
                'OK'
            );</script>";
        }else {
            echo "<script>Notiflix.Report.Failure(
                '',
                '".$alertback->title."',
                'OK'
            );</script>";
        }
		unset($_SESSION['alertback']);
	}
?>
<script>
    Notiflix.Notify.Init({
        zindex: 9000000,
    });
</script>
<?
	$site_notify=getOption('site_notify');
	$image_notify=upload_url('notify.jpg');
	if (empty($site_notify)==FALSE) {
		echo '<section class="custom-social-proof">
              <div class="custom-notification">
                <div class="custom-notification-container">
                  <div class="custom-notification-image-wrapper">
                    <img src="'.$image_notify.'">
                  </div>
                  <div class="custom-notification-content-wrapper">
                    <p class="custom-notification-content">
                      <small>'.$site_notify.'</b>
                      <small>'.DATE('d-m-Y H:i').'</small>
                    </p>
                  </div>
                </div>
                <div class="custom-close"></div>
              </div>
            </section>';
	}
?>

<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/bootstrap.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.appear.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/waypoints.min.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/modernizr-latest.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/SmoothScroll.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.superslides.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.flexslider.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/owl.carousel.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.isotope.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/rev-slider/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/rev-slider/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.mb.YTPlayer.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/plugins.js"></script>
<script type="text/javascript" src="<?=dist_url('user/')?>js/custom.js?<?=time()?>"></script>

<!-- End JS Files -->

<?=getOption('html_area_body_end')?>
</body>

</html>