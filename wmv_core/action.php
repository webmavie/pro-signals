<?php
session_start();
require "config.php";
require "core.php";
require "functions.php";
require "models.php";
require "variables.php";
// Actionları aşağıdan yazmağa başlaya bilirsiniz.

if ($_GET['form'] == 'contact') {
    // sleep
    $fullname=escape_string($_POST['fullname']);
    $email=escape_string($_POST['email']);
    $subject=escape_string($_POST['subject']);
    $message=escape_string($_POST['message']);

    if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
        $response=array(
            "icon" => "error",
            "title" => $_['please_fill_all_inputs'],
        );
    }else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response=array(
                "icon" => "error",
                "title" => $_['please_fill_all_input_correct'],
            );
        }elseif (strlen($fullname) <= 3 || strlen($message) > 350 || strlen($message) <= 10 || strlen($subject) > 100 || strlen($subject) <= 3) {
            $response=array(
                "icon" => "error",
                "title" => $_['please_fill_all_input_correct'],
            );
        }else {
            $message="Fullname: {$fullname} | Email: {$email} <hr> {$message}";
            $send=$mail->send(getOption('email'), $subject, $message);
            if (!$send) {
                $response=array(
                    "icon" => "error",
                    "title" => $_['system_error'],
                );
            }else {
                $response=array(
                    "icon" => "success",
                    "title" => $_['email_has_been_recevied'],
                );
            }
        }
    }

    echo json_encode($response);
    exit;
}

if ($_GET['form'] == 'register') {
    // sleep
    
    $fullname=$_POST['fullname'];
    $country=$_POST['country'];
    $telegram_username=$_POST['telegram_username'];
    $whatsapp_no=$_POST['whatsapp_no'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    if (empty($fullname) || empty($country) || empty($telegram_username) || empty($whatsapp_no) || empty($email) || empty($password)) {
        $response=array(
            "icon" => "error",
            "title" => $_['please_fill_all_inputs'],
        );
    }else {
        if (empty($countries[$country])==TRUE || strlen($fullname) <= 3 || strlen($telegram_username) <= 3) {
            $response=array(
                "icon" => "error",
                "title" => $_['please_fill_all_input_correct'],
            ); 
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response=array(
                "icon" => "error",
                "title" => $_['please_fill_all_input_correct'],
            );
        }else {
            $findUser=$db->get_onerow('users', array('email' => $email));
            if (empty($findUser['id'])==TRUE) {
                $add=addUser($_POST, 1);
                if (!$add) {
                    $response=array(
                        "icon" => "error",
                        "title" => $_['system_error'],
                    );
                }else {
                    $db->add_row('logs_actions', array('uid' => 0, 'email' => $email, 'page' => 'register', 'ip' => getUserIP()));
                    $response=array(
                        "icon" => "success",
                        "title" => $_['please_check_email'],
                    );
                }
            }else {
                $response=array(
                    "icon" => "error",
                    "title" => $_['user_now_exists'],
                );
            }
        }
    }

    echo json_encode($response);
    exit;
}

if ($_GET['form'] == 'login') {
    // sleep

    $email=strtolower(trim(escape_string($_POST['email'])));
    $password=sha1(md5($_POST['password']));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response=array(
            "icon" => "error",
            "title" => $_['please_fill_all_input_correct'],
        );
    }else {
        $findUser=$db->get_onerow('users', array('email' => $email, 'password' => $password));
        if (empty($findUser['id'])) {
            $response=array(
                "icon" => "error",
                "title" => $_['user_not_exists'],
            );
        }else {
            if ($findUser['activated']==0) {
                setcookie('activate_email', $email, time()+(60*10), '/');
                $response=array(
                    "icon" => "warning",
                    "title" => $_['you_didt_confirm_email'],
                    "confirm_area" => "<center><a style='color:#FFF;' href='".action_url(array('act' => 'resend_confirm'))."'>{$_['resend_confirm_email']}</a></center>", 
                );
            }else {
                $db->add_row('logs_actions', array('uid' => $findUser['id'], 'email' => $findUser['email'], 'page' => 'login', 'ip' => getUserIP()));

                setcookie('login_hash', $findUser['login_hash'], time()+(60*60), '/');
                $response=array(
                    "icon" => "success",
                    "title" => $_['login_success'],
                    "redirect" => base_url('?'.time().'#statements')
                );
            }
        }
    }

    echo json_encode($response);
    exit;
}

if ($_GET['form'] == 'recover') {
    // sleep

    $email=strtolower(trim(escape_string($_POST['email'])));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response=array(
            "icon" => "error",
            "title" => $_['please_fill_all_input_correct'],
        );
    }else {
        $findUser=$db->get_onerow('users', array('email' => $email));
        if (empty($findUser['id'])) {
            $response=array(
                "icon" => "success",
                "title" => $_['recovery_email_sended'],
            );
        }else {
            $newpassword=trim(generateRandomString(8));
            $newpassword_hash=sha1(md5($newpassword));
            $newlogin_hash=sha1(md5($email.$newpassword_hash));
            $update=$db->update_row("users", array("id" => $findUser['id']), array("password" => $newpassword_hash, "login_hash" => $newlogin_hash, "activated" => 1));
            if (!$update) {
                $response=array(
                    "icon" => "error",
                    "title" => $_['system_error'],
                );
            }else {
                $convert=array(
                    '%fullname%' => $findUser['fullname'],
                    '%email%' => $findUser['email'],
                    '%newpassword%' => $newpassword
                );
                $send=$mail->send($email, "{$_['account_recovery_link']} | ".getOption('site_name'), str_replace(array_keys($convert), array_values($convert), $_['recovery_message']));
    
                if (!$send) {
                    $response=array(
                        "icon" => "error",
                        "title" => $_['system_error'],
                    );
                }else {
                    $response=array(
                        "icon" => "success",
                        "title" => $_['recovery_email_sended'],
                    );
                }
            }
        }
    }

    echo json_encode($response);
    exit;
}

if ($_GET['act'] == 'resend_confirm') {
    // sleep

    if (!isset($_COOKIE['activate_email'])) {
        $response=array(
            "icon" => "error",
            "title" => $_['session_over'],
        );
    }else {
        $email=$_COOKIE['activate_email'];
        $findUser=$db->get_onerow('users', array('email' => $email));
        if (empty($findUser['id'])) {
            $response=array(
                "icon" => "error",
                "title" => $_['system_error'],
            );
        }else {
            $convert=array(
                '%fullname%' => $findUser['fullname'],
                '%link%' => action_url(array('act' => 'confirm_email', 'hash' => $findUser['one_time_hash'])),
            );
            $send=$mail->send($email, "{$_['account_verification_link']} | ".getOption('site_name'), str_replace(array_keys($convert), array_values($convert), $_['verification_message']));

            if (!$send) {
                $response=array(
                    "icon" => "error",
                    "title" => $_['system_error'],
                );
            }else {
                $response=array(
                    "icon" => "success",
                    "title" => $_['confirmation_message_sent'],
                );
            }
        }
    }

    $_SESSION['alertback']=json_encode($response);
    header('Location: '.base_url());
    exit;
}

if ($_GET['act']=='confirm_email' AND empty($_GET['hash'])==FALSE) {
    $findUser=$db->get_onerow('users', array('one_time_hash' => escape_string($_GET['hash'])));
    if (empty($findUser['id'])) {
        $response=array(
            "icon" => "error",
            "title" => $_['hash_value_invalid'],
        );
    }elseif ($findUser['activated']==1) {
        $response=array(
            "icon" => "success",
            "title" => $_['account_already_active'],
        );
    }else {
        $upt=$db->update_row('users', array('id' => $findUser['id']), array('activated' => 1));
        if (!$upt) {
            $response=array(
                "icon" => "error",
                "title" => $_['system_error'],
            );
        }else {
            setcookie('login_hash', $findUser['login_hash'], time()+(60*60), '/');
            $response=array(
                "icon" => "success",
                "title" => $_['account_activated'],
                "redirect" => base_url('?'.time().'#statements'),
            );
        }
    }

    $_SESSION['alertback']=json_encode($response);
    header('Location: '.base_url());
    exit;
}

if ($_GET['act']=='logout') {
    setcookie('login_hash', '', time()-60, '/');
    header('Location: '.base_url());
    exit;
}

if ($_GET['form'] == 'download_request') {
    // sleep
    $fullname=escape_string($_POST['fullname']);
    $email=escape_string($_POST['email']);

    if (empty($fullname) || empty($email)) {
        $response=array(
            "icon" => "error",
            "title" => $_['please_fill_all_inputs'],
        );
    }else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response=array(
                "icon" => "error",
                "title" => $_['please_fill_all_input_correct'],
            );
        }elseif (strlen($fullname) <= 3 || strlen($fullname) >= 70) {
            $response=array(
                "icon" => "error",
                "title" => $_['please_fill_all_input_correct'],
            );
        }else {
            $db->add_row('logs_actions', array('uid' => 0, 'email' => "{$fullname} {$email}", 'page' => 'download_request', 'ip' => getUserIP()));

            $download_link=action_url(array('act' => 'download', 'hash' => getOption('download_hash'), 'id' => $db->lastid()));
            $send=$mail->send($email, getOption('site_name').' | Download e-book', "Hi <b>{$fullname}</b>. Use the link below to download the book. <br><a href='{$download_link}'>{$download_link}</a>");
            if (!$send) {
                $response=array(
                    "icon" => "error",
                    "title" => $_['system_error'],
                );
            }else {
                $response=array(
                    "icon" => "success",
                    "title" => $_['file_sended_your_email'],
                );
            }
        }
    }

    echo json_encode($response);
    exit;
}

if ($_GET['act'] == 'download') {
    $hash=escape_string($_GET['hash']);
    $newname=slug(getOption('site_name').' E-book').".pdf";
    $orginal_hash=getOption('download_hash');
    $orginal_file=upload_dir(getOption('download_file'));
    if ($orginal_hash!==$hash) {
        $response=array(
            "icon" => "warning",
            "title" => $_['file_not_found'],
        );
    }else {
        if (!file_exists($orginal_file)) {
            $response=array(
                "icon" => "warning",
                "title" => $_['file_not_found'],
            );
        }else {
            $findLog=$db->get_onerow('logs_actions', array('id' => $_GET['id']));
            if (empty($findLog['id'])) {
                if (!isset($_GET['id'])) {
                    $name=$_COOKIE['admin_logined']=='1'?'Admin':'Undefined';
                }else {
                    $name='Undefined';
                }
            }else {
                $name="{$findLog['email']}";
            }
            $db->add_row('logs_actions', array('uid' => 0, 'email' => "{$name}", 'page' => 'downloaded_ebook', 'ip' => getUserIP()));

            header("Content-type:application/pdf");
            // It will be called downloaded.pdf
            header("Content-Disposition:attachment;filename=".$newname);
            // The PDF source is in original.pdf
            readfile($orginal_file);
            exit;
        }
    }

    $_SESSION['alertback']=json_encode($response);
    header('Location: '.base_url());
    exit;
}

if ($_GET['form'] == 'join_newsletter') {
    // sleep

    $email=strtolower(trim(escape_string($_POST['email'])));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response=array(
            "icon" => "error",
            "title" => $_['please_fill_all_input_correct'],
        );
    }else {
        $findNewsletter=$db->get_onerow('newsletter', array('email' => $email));
        if (empty($findNewsletter['id'])) {
            $db->add_row('newsletter', array('email' => $email, 'ip' => getUserIP()));
            $response=array(
                "icon" => "success",
                "title" => $_['newsletter_registration_completed'],
            );
        }else {
            $response=array(
                "icon" => "success",
                "title" => $_['newsletter_registration_completed'],
            );
        }
    }

    echo json_encode($response);
    exit;
}

// Admin funcs
if ($_POST['form']=='login_admin') {
    $un=trim($_POST['username']);
    $pw=trim($_POST['password']);
    if ($un!==getOption('admin_username')) {
        $response=array('title' => 'Error', 'text' => 'Username or password incorrect!', 'status' => 'error');
    }elseif ($pw!==getOption('admin_password')) {
        $response=array('title' => 'Error', 'text' => 'The password is incorrect.', 'status' => 'error');
    }else {
        $response=array('title' => 'Logined!', 'text' => '', 'status' => 'success');
        setcookie('un', $un, time()+(60*60*24), '/');
        setcookie('pw', $pw, time()+(60*60*24), '/');
        setcookie('admin_logined', '1', time()+(60*60*24), '/');
    }

    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/login'));
    exit;
}

if ($_GET['act'] == 'exit_admin') {
    setcookie('un', '', time()-60, '/');
    setcookie('pw', '', time()-60, '/');
    setcookie('logined', '', time()-60, '/');
    header('Location: '.base_url());
    exit;
}

if ($_POST['form']=='options_save') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    unset($_POST['form']);
    $_POST['site_title']=json_encode($_POST['site_title']);
    $_POST['site_description']=json_encode($_POST['site_description']);
    $_POST['site_slogan']=json_encode($_POST['site_slogan']);

    $all_upt=0;
    $no_upt=0;
    $all_count=count($_POST);

    $no_img='';
    $get_old['logo']=getOption('logo');
    if (!empty($_FILES['file_image']['tmp_name'])) {
        $filename='logo_'.mt_rand().rand().'.png';
        $newfile_img=upload_dir($filename);
        if(move_uploaded_file($_FILES['file_image']['tmp_name'], $newfile_img)) {
            $_POST['logo']=$filename;
        }else{
            $no_img='The logo could not be uploaded!';
        }
    }

    $no_pdf='';
    $get_old['download_file']=getOption('download_file');
    if (!empty($_FILES['file_pdf']['tmp_name'])) {
        $filename='download_'.mt_rand().rand().'.pdf';
        $newfile_pdf=upload_dir($filename);
        if(move_uploaded_file($_FILES['file_pdf']['tmp_name'], $newfile_pdf)) {
            $_POST['download_file']=$filename;
        }else{
            $no_pdf='The pdf could not be uploaded!';
        }
        $_POST['download_hash']=sha1(md5($filename.time().mt_rand()));
    }

    unset($_POST['file_image']);
    unset($_POST['file_pdf']);


    foreach ($_POST as $key => $value) {
        $upt=updateOption(trim($key), escape_string($value));
        if ($upt == TRUE) {
            $all_upt+=1;
        }else {
            $no_upt+=1;
        }
    }
    
    if ($no_upt > 0 AND $all_upt > 0) {
        if ($no_img=='') {
            @unlink(upload_dir($get_old['logo']));
        }
        if ($no_pdf=='') {
            @unlink(upload_dir($get_old['download_file']));
        }
        $response=array('title' => 'Error', 'text' => 'Some settings could not be saved.'.$no_img.$no_pdf, 'status' => 'error');
    }elseif ($no_upt == 0 AND $all_count > 0) {
        if ($no_img=='') {
            @unlink(upload_dir($get_old['logo']));
        }
        if ($no_pdf=='') {
            @unlink(upload_dir($get_old['download_file']));
        }
        $response=array('title' => 'Saved!', 'text' => ''.$no_img.$no_pdf, 'status' => 'success');
    }else {
        @unlink($newfile_img);
        @unlink($newfile_pdf);
        $response=array('title' => 'Error', 'text' => 'System error. Check again shortly'.$no_img, 'status' => 'error');
    }

    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/options'));
    exit;
}

if ($_GET['act'] == 'delete') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    switch ($_GET['mode']) {
        case 'user':
            $backpage='users';
            $del=$db->delete_row('users', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;

        case 'user_say':
            $backpage='user_says';
            $del=$db->delete_row('user_says', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;

        case 'slides':
            $backpage='slides';
            $find=$db->get_onerow('slides', array('id' => $_GET['id']));
            @unlink('slides/'.$find['image']);
            $del=$db->delete_row('slides', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;

        case 'we_offer':
            $backpage='we_offer';
            $del=$db->delete_row('what_offer', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;

        case 'packages':
            $backpage='packages';
            $del=$db->delete_row('packages', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;
        case 'faq':
            $backpage='faq';
            $del=$db->delete_row('faq', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;
        case 'skills':
            $backpage='skills';
            $del=$db->delete_row('skills', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;
        case 'results':
            $backpage='results';
            $find=$db->get_onerow('results', array('id' => $_GET['id']));
            @unlink('results/'.$find['image']);
            $del=$db->delete_row('results', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;
        case 'result_data':
            $backpage='result_data?id='.$_GET['rid'];
            $del=$db->delete_row('result_data', array('id' => $_GET['id']));
            if ($del) {
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
            }else {
                $response=array('title' => 'Error', 'text' => 'The operation failed!', 'status' => 'error');
            }
            break;

        case 'logs':
            $backpage='dashboard';
        	$days=$_GET['day'];
        	if ($days >= 7 AND is_numeric($days)) {
        		$del=$db->console("DELETE FROM {$prefix}_logs WHERE date(reg_date) < date_sub(curdate(), interval ".$days." day)");
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
        	}else {
                $response=array('title' => 'Error', 'text' => 'Deletion date is not allowed less than 7 days!', 'status' => 'error');
        	}
        	break;

        case 'logs_actions':
            $backpage='logs';
        	$days=$_GET['day'];
        	if ($days >= 7 AND is_numeric($days)) {
        		$del=$db->console("DELETE FROM {$prefix}_logs_actions WHERE date(reg_date) < date_sub(curdate(), interval ".$days." day)");
                $response=array('title' => 'Success', 'text' => 'The operation was successful!', 'status' => 'success');
        	}else {
                $response=array('title' => 'Error', 'text' => 'Deletion date is not allowed less than 7 days!', 'status' => 'error');
        	}
        	break;
        
        default:
            $backpage='dashboard';
            $response=array('title' => 'Error', 'text' => 'Delete mode not correct', 'status' => 'error');
            break;
    }

    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/'.$backpage));
    exit;
}

if ($_GET['act']=='log_detail') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $find=$db->get_onerow('logs', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('error' => 'ID not correct!');
    }else {
        $notes=json_decode($find['note'], TRUE);
        $response=array();
        foreach ($notes as $key => $note) {
            if (empty(trim($note))) { continue; }
            $key=str_replace(array_keys($geo_convert), array_values($geo_convert), $key);
            $response[$key]=$note;
        }
    }
    

    echo json_encode($response);
    exit;
}

if ($_POST['form']=='add_user_says') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->add_row('user_says', $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/user_says'));
    exit;
}

if ($_POST['form']=='edit_user_says') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    unset($_POST['id']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $upt=$db->update_row('user_says', array('id' => $id), $data);
    if ($upt) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/user_says'));
    exit;
}

if ($_POST['form']=='add_slides') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $filename='slide_'.mt_rand().rand().'.png';
    $newfile=upload_dir('slides/'.$filename);
    if(move_uploaded_file($_FILES['file_image']['tmp_name'], $newfile)) {
        $_POST['image']=$filename;

        unset($_POST['form']);
        unset($_POST['file_image']);
        $data=array();
        foreach ($_POST as $key => $value) {
            $data[$key]=escape_string($value);
        }
        $add=$db->add_row('slides', $data);
        if ($add) {
            $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
        }else {
            @unlink($newfile);
            $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
        }
    } else{
        $response=array('title' => 'Error', 'text' => 'Image not uploaded!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/slides'));
    exit;
}

if ($_POST['form']=='edit_slides') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    $old_image=$_POST['old_image'];
    $_POST['image']=$old_image;

    $resume=1;
    if (!empty($_FILES['file_image']['tmp_name'])) {
        $filename='slide_'.mt_rand().rand().'.png';
        $newfile=upload_dir('slides/'.$filename);
        if(move_uploaded_file($_FILES['file_image']['tmp_name'], $newfile)) {
            $_POST['image']=$filename;
        }else{
            $resume=0;
        }
    }

    unset($_POST['id']);
    unset($_POST['form']);
    unset($_POST['file_image']);
    unset($_POST['old_image']);

    if ($resume == 1) {
        $data=array();
        foreach ($_POST as $key => $value) {
            $data[$key]=escape_string($value);
        }
        $upt=$db->update_row('slides', array('id' => $id), $data);
        if ($upt) {
            @unlink(upload_dir('slides/'.$old_image));
            $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
        }else {
            @unlink($newfile);
            $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
        }
    }else {
        $response=array('title' => 'Error', 'text' => 'Image not uploaded!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/slides'));
    exit;
}

if ($_POST['form']=='add_we_offer') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->add_row('what_offer', $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/we_offer'));
    exit;
}

if ($_POST['form']=='edit_we_offer') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    unset($_POST['id']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->update_row('what_offer',  array('id' => $id), $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/we_offer'));
    exit;
}

if ($_POST['form']=='add_packages') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $_POST['detalis']=json_encode($_POST['detalis']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->add_row('packages', $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/packages'));
    exit;
}

if ($_POST['form']=='edit_packages') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    $_POST['detalis']=json_encode($_POST['detalis']);
    unset($_POST['id']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->update_row('packages', array('id' => $id), $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/packages'));
    exit;
}

if ($_POST['form']=='add_faq') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->add_row('faq', $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/faq'));
    exit;
}

if ($_POST['form']=='edit_faq') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    unset($_POST['id']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->update_row('faq',  array('id' => $id), $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/faq'));
    exit;
}

if ($_POST['form']=='add_skills') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->add_row('skills', $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/skills'));
    exit;
}

if ($_POST['form']=='edit_skills') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    unset($_POST['id']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->update_row('skills',  array('id' => $id), $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/skills'));
    exit;
}

if ($_POST['form']=='add_results') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $filename='result_'.mt_rand().rand().'.png';
    $newfile=upload_dir('results/'.$filename);
    if(move_uploaded_file($_FILES['file_image']['tmp_name'], $newfile)) {
        $_POST['image']=$filename;
        $_POST['table_titles']=json_encode($_POST['table_titles']);
        $_POST['hash']=sha1(md5(time().mt_rand()));

        unset($_POST['form']);
        unset($_POST['file_image']);
        $data=array();
        foreach ($_POST as $key => $value) {
            $data[$key]=escape_string($value);
        }
        $add=$db->add_row('results', $data);
        if ($add) {
            $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
        }else {
            @unlink($newfile);
            $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
        }
    } else{
        $response=array('title' => 'Error', 'text' => 'Image not uploaded!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/results'));
    exit;
}

if ($_POST['form']=='edit_results') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    $old_image=$_POST['old_image'];
    $_POST['image']=$old_image;
    $_POST['table_titles']=json_encode($_POST['table_titles']);


    $resume=1;
    if (!empty($_FILES['file_image']['tmp_name'])) {
        $filename='result_'.mt_rand().rand().'.png';
        $newfile=upload_dir('results/'.$filename);
        if(move_uploaded_file($_FILES['file_image']['tmp_name'], $newfile)) {
            $_POST['image']=$filename;
        }else{
            $resume=0;
        }
    }

    unset($_POST['id']);
    unset($_POST['form']);
    unset($_POST['file_image']);
    unset($_POST['old_image']);

    if ($resume == 1) {
        $data=array();
        foreach ($_POST as $key => $value) {
            $data[$key]=escape_string($value);
        }
        $upt=$db->update_row('results', array('id' => $id), $data);
        if ($upt) {
            @unlink(upload_dir('results/'.$old_image));
            $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
        }else {
            @unlink($newfile);
            $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
        }
    }else {
        $response=array('title' => 'Error', 'text' => 'Image not uploaded!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/results'));
    exit;
}

if ($_POST['form']=='add_result_data') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $_POST['data']=json_encode($_POST['data']);
    
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->add_row('result_data', $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/result_data?id='.$_POST['rid']));
    exit;
}

if ($_POST['form']=='edit_result_data') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $_POST['data']=json_encode($_POST['data']);
    $rid=$_POST['rid'];
    $sid=$_POST['sid'];
    unset($_POST['rid']);
    unset($_POST['sid']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $add=$db->update_row('result_data', array('id' => $sid), $data);
    if ($add) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/result_data?id='.$rid));
    exit;
}

if ($_GET['act']=='results_show_all_language') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $rsal=getOption('results_show_all_language');
    $upt=$rsal=='1'?updateOption('results_show_all_language', 0):updateOption('results_show_all_language', 1);
    if ($upt) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/results'));
    exit;
}

if ($_POST['form']=='edit_sections') {
    if ($_COOKIE['admin_logined'] !== '1') {echo 'The session is over. Please log in again!';exit;}
    $id=$_POST['id'];
    unset($_POST['id']);
    unset($_POST['form']);
    $data=array();
    foreach ($_POST as $key => $value) {
        $data[$key]=escape_string($value);
    }
    $upt=$db->update_row('sections', array('id' => $id), $data);
    if ($upt) {
        $response=array('title' => 'Saved!', 'text' => '', 'status' => 'success');
    }else {
        $response=array('title' => 'Error', 'text' => 'System error!', 'status' => 'error');
    }
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/sections'));
    exit;
}
?>