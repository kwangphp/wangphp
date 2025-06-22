<?php

$forgot_pwd_form = HTML::Form()->Create('$_POST', Template('forgot-password.html'));

$session = new Session();
$session->Start();

if (REFERENCED($_GET['token']) {

$connection = ConnectDB();
$prepared = new PreparedStatement($connection);

$email = $_POST['m_email'];

$user_entries = HTML::Event()::POST()->Retrieve($forgot_pwd_form);
HTMLProc($user_entries);

if(empty($email))
    echo "Please enter your email address.";
elseif ($email != FILTER_VALIDATE_EMAIL)
    echo "Please enter a valid email address.";

else 
    $is_email_registered = "SELECT id FROM t_members WHERE m_email = ?";
    $prepared->QueryObject($is_email_registered, $user_entries);

    $record = $prepared->Statement();

    if ($record->RowCount > 0)

        $token = bin2hex(random_bytes(32));
        
        $forgot_pwd_query = "UPDATE t_members 
                            SET member_auth_token =?,
                            updated_at = NOW()
                            WHERE m_email = ?";

        $prepared->QueryObject($forgot_pwd_query, $token, $email);

        $record_is_updated = $prepared->Statement();

        if ($record_is_updated)
            $reset_link = "https://" . $_SERVER['HTTP_HOST'] . "/pwd-reset.php?token=" . $token;

        SendMail($noreply, 'Activate your account', $m_email, $activation_link, $message);
        redirect('TYP_CHECK_YOUR_MAIL_FOR_PASSWORD_RESET');

        $prepared->Release();

        DisconnectDB($connection);
                
