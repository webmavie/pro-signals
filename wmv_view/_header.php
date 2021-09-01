<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?=getOption('site_title', $_['code'])?></title>
    <meta name="description" content="<?=getOption('site_description', $_['code'])?>" />
    <meta name="keywords" content="<?=getOption('site_description')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
	<meta property="og:locale" content="<?=$_['locale']?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?=getOption('og_title')?>>">
	<meta property="og:description" content="<?=getOption('og_description')?>">
	<meta property="og:url" content="<?=base_url()?>">
	<meta property="og:site_name" content="<?=getOption('site_name')?>">
	<meta property="og:image" content="<?=upload_url(getOption('logo'))?>">
	<meta property="og:image:secure_url" content="<?=upload_url(getOption('logo'))?>">
	<meta property="og:image:width" content="60">
	<meta property="og:image:height" content="60">
	<meta property="og:image:alt" content="<?=getOption('site_name')?>">
	<meta property="og:image:type" content="image/png">
	<!-- CSS Files -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/reset.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/animate.min.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/bootstrap.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/style.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/flexslider.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/font-awesome.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/owl.carousel.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/settings.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/prettyPhoto.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/responsive.css" />
	<link rel="stylesheet" href="<?=dist_url('user/')?>css/player/YTPlayer.css" />
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/notiflix@2.7.0/dist/notiflix-aio-2.7.0.min.js"></script>

	<link rel="stylesheet" href="<?=dist_url('user/')?>css/custom.css?<?=time()?>" />
	<link rel="shortcut icon" href="<?=dist_url('user/')?>images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?=dist_url('user/')?>images/favicon.ico" type="image/x-icon">
	<!-- End CSS Files -->
	<?=getOption('html_area_head')?>

	<?php
        if ($_SESSION['ionline']!==2) {
			if ($_SESSION['ionline']!==1) {
				@updateOption('total_impression', (getOption('total_impression')+1));
			}
			$findmyip=$db->get_onerow('logs', array('ip' => getUserIP()));
            if (!empty($findmyip['id'])) {
                $db->update_row('logs', array('id' => $findmyip['id']), array('times' => ($findmyip['times']+1)));
				$_SESSION['ionline']=2;
            }else {
				$myipinfo=ip_info();
				unset($myipinfo->geoplugin_credit);
				if ($myipinfo->geoplugin_status == "200" OR $myipinfo->geoplugin_status == "206") {
					$dbdata=array(
						'continent_name' => escape_string($myipinfo->geoplugin_continentName),
						'country_code' => escape_string($myipinfo->geoplugin_countryCode),
						'country_name' => escape_string($myipinfo->geoplugin_countryName),
						'ip' => getUserIP(),
						'note' => escape_string(json_encode($myipinfo)),
					);
					$db->add_row('logs', $dbdata);
					$_SESSION['ionline']=2;

				}
			}
			$_SESSION['ionline']=1;
        }
    ?>
</head>
	
	
<body data-spy="scroll" data-target=".nav-menu" data-offset="50">
<?=getOption('html_area_body_start')?>

<div class="socialicons">
        <a href="https://wa.me/<?=str_replace(array("+", " "), "", getOption('whatsapp_number'))?>" class="float-whatsapp" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a> 
        <a href="https://t.me/<?=getOption('telegram_username')?>" class="float-telegram" target="_blank">
        <i class="fa fa-telegram my-float"></i>
    </a> 
</div>
<div id="pageloader">   
    <div class="loader-item">
      <img src="<?=dist_url('user/')?>images/loading.gif" alt='loader' />
    </div>
</div>
<!-- Home Section -->
	<section id="home" class="">
	
	
		<section id="pagetop" class="contain">
		
			<div class="inner pagetop">
			
				<div class="col-xs-6 left"><div style="color:white">
					<?=getOption('site_slogan', $_['code'])?>
					</div>
				</div>
				
				<div class="col-xs-6 right">
					<button onclick="return $('#login-register-form').modal({ backdrop: 'static',keyboard: false});" class="btn btn-warning btn-sm"><?=$_['register']?></button>
					<a href="mailto:<?=getOption('email')?>">
						<i class="fa fa-envelope" style="color:white"></i>
					</a>
					<a href="<?=getOption('facebook')?>">
						<i class="fa fa-facebook-f" style="color:white"></i>
					</a>
					<a href="<?=getOption('instagram')?>">
						<i class="fa fa-instagram" style="color:white"></i>
					</a>
					<a>
					<?php
						foreach (glob(base_dir(LANGUAGE_DIR)."*.php") as $flangname) {
							$basename=basename($flangname, '.php');
							echo '<a href="'.base_url('?language='.$basename).'">
									<img src="'.base_url(LANGUAGE_DIR.'/'.$basename.'.png').'">
								</a>';
						}
					?>
				</div>
				
				
				<div class="clear"></div>
			</div>
		
		</section>		
		
	<!-- Navigation Section -->
	<section id="navigation" class="shadow">
	
		<div class="inner navigation">
			
			<!-- Logo Img -->
			<div class="logo">
				<a class="scroll" href="<?=base_url()?>"><img src="<?=upload_url(getOption('logo'))?>" alt="Logo"/></a>
			</div>
			
			<!-- Nav Menu -->
			<div class="nav-menu">
				
				<ul class="nav main-nav">
				
					<li class="active"><a class="scroll" href="#home"><?=$_['home']?></a></li>
					<li><a class="scroll" href="#about"><?=$_['our_vision']?></a></li>
					<li><a class="scroll" href="#reviews"><?=$_['testimonials']?></a></li>
					<li><a class="scroll" href="#statements"><?=$_['statements']?></a></li>
					<li><a class="scroll" href="#services"><?=$_['services']?></a></li>
					<li><a class="scroll" href="#prices"><?=$_['prices']?></a></li>
					<li><a class="scroll" href="#faq"><?=$_['faq']?></a></li>
					<li><a class="scroll" href="#contact"><?=$_['contact']?></a></li>
				</ul>
				
			</div>
			
			
				<!-- Dropdown Menu For Mobile Devices-->
				<div class="dropdown mobile-drop">
				  <a data-toggle="dropdown" class="mobile-menu" href="#"><i class="fa fa-bars"></i></a>
				  <ul class="nav dropdown-menu fullwidth" role="menu" >
				  	<li><a class="scroll" href="#home"><?=$_['home']?></a></li>
					<li><a class="scroll" href="#about"><?=$_['our_vision']?></a></li>
					<li><a class="scroll" href="#reviews"><?=$_['testimonials']?></a></li>
					<li><a class="scroll" href="#statements"><?=$_['statements']?></a></li>
					<li><a class="scroll" href="#services"><?=$_['services']?></a></li>
					<li><a class="scroll" href="#prices"><?=$_['prices']?></a></li>
					<li><a class="scroll" href="#faq"><?=$_['faq']?></a></li>
					<li><a class="scroll" href="#contact"><?=$_['contact']?></a></li>
				  </ul>
				</div>
		
			<div class="clear"></div>
		</div>
	
	</section>
	<!-- End Navigation Section -->
	