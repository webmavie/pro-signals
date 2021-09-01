<?php
    $_=array();

    $code_to_lang=array(
        'es' => 'Spanish',
        'en' => 'English',
    );
    if (isset($_GET['language'])) {
        $_SESSION['active_language']=$_GET['language'];
    }
    $active_lang=isset($_SESSION['active_language'])?$_SESSION['active_language']:'en';

    $lang_file_active=base_dir(LANGUAGE_DIR.$active_lang.'.php');
    $lang_file_default=base_dir(LANGUAGE_DIR.DEFAULT_LANGUAGE.'.php');

    if (file_exists($lang_file_active)) {
        include($lang_file_active);
    }else {
        unset($_SESSION['active_language']);
        include($lang_file_default);
    }



?>