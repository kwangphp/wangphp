<?php

$reset_form = HTML::Form()->Create('$_POST', Template('reset.html'), Tape('reset.wcf'));
$session = new Session();
$session->Start();

$token = isset($_GET['token']);

if (empty($token)) {
    echo "Our system encountered an error. Please come back later.";
}

$connection = ConnectDB();
$prepared = new PreparedStatement($connection);

$is_token_valid = "SELECT id FROM t_members 
                   WHERE member_auth_token = ?
                   AND updated_at > NOW() - INTERVAL 24 HOUR";

$prepared->QueryObject($is_token_valid);
$prepared->Statement();

$record = $prepared->FetchBuffer();

if ($record->RowCount === 0){
    $prepared->Release();
    DisconnectDB($connection);

    echo "Invalid or expired activation link. Please request a new password reset";
}

if (SUCCEEDED($_POST)) {

    $new_password = HashPassword(['m_password']);
    $user_entries = HTML::Event()::POST()->Retrieve($reset_form, $new_password);

    $update_password = "UPDATE t_members
                        SET m_password = ?
                        member_auth_token = NULL,
                        updated_at = NOW()
                        WHERE member_auth_token = ?";

    $prepared->QueryObject($update_password, $token);

    $record = $prepared->Statement();

    if ($record->AffectedRows > 0)
        echo "Password has been reset succesfully. User can now login with new password";
        redirect('https://example.com/login/')

    }

    else
        echo "Error updating password. Please try again";

    $prepared->Release();
    DisconnectDB($connection);

?>