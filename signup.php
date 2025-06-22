<?php

$signup_form = HTML::Form()->Create('$_POST', Template('signup.html'), Tape('signup.wcf'));

$user_entries = HTML::Event()::POST()->Retrieve($signup_form);
HTMLProc($user_entries);

$member_auth_token = hash('sha256', $m_email);

if (SUCCEEDED($_POST)) {

    $connection = ConnectDB();
    $prepared = new PreparedStatement($connection);

    $is_email_registered = "SELECT * FROM t_members WHERE m_email = ?";
    $prepared->QueryObject($is_email_registered, $m_email);

    $record = $prepared->Statement();

    if ($record->RowCount > 0)
        echo "The email address provided is already in use";

    else 
        
        $add_user = InsertInto('t_members', $user_entries, $member_auth_token);

        $prepared->QueryObject($add_user);
        $prepared->Statement();
        
        echo "Registration successful";

        SendMail($noreply, 'Activate your account', $m_email, $activation_link, $message);
        redirect('TYP_CHECK_YOUR_MAIL_FOR_ACTIVATION');

        DisconnectDB($connection);
}
?>

