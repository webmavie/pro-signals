<?php
function escape_string($string) {
    global $db;
    return trim(substr($db->escape_string($string), 1, -1));
}

function getOption($ckey, $lang_code='') {
    global $db;
    $get=$db->get_onerow('options', array('key' => $ckey));
    if ($lang_code!=='') {
        $get['value']=json_decode($get['value'])->$lang_code;
    }
    return $get['value'];
}

function updateOption($ckey, $cvalue) {
    global $db;
    $update=$db->update_row('options', array('key' => $ckey), array('value' => $cvalue));
    if ($update) {
        return TRUE;
    }else {
        return FALSE;
    }
}

function addUser($post, $send_confirm=0) {
    global $db;
    global $mail;
    global $_;
    $lang_code=$_['code'];
    $fullname=escape_string($post['fullname']);
    $country=escape_string($post['country']);
    $telegram_username=escape_string($post['telegram_username']);
    $whatsapp_no=escape_string($post['whatsapp_no']);
    $email=strtolower(trim(escape_string($post['email'])));
    $password=sha1(md5($post['password']));
    $userip=getUserIP();
    $one_time_hash=sha1($email.time().rand());

    $data=array(
        'lang_code' => $lang_code,
        'fullname' => $fullname,
        'country' => $country,
        'telegram_username' => $telegram_username,
        'whatsapp_no' => $whatsapp_no,
        'email' => $email,
        'password' => $password,
        'login_hash' => sha1(md5($email.$password)),
        'one_time_hash' => $one_time_hash,
        'ip' => $userip,
    );

    if ($send_confirm==1) {
        $convert=array(
            '%fullname%' => $fullname,
            '%link%' => action_url(array('act' => 'confirm_email', 'hash' => $one_time_hash)),
        );
        $mail->send($email, "{$_['account_verification_link']} | ".getOption('site_name'), str_replace(array_keys($convert), array_values($convert), $_['verification_message']));
    }

    $add=$db->add_row('users', $data);
    if ($add) {
        return TRUE;
    }else {
        return FALSE;
    }
}
?>