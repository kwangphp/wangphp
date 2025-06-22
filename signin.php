<?php

$login_form = HTML::Form()->Create('$_POST', Template('login.html'), Tape('login.wcf'));

$user_entries = HTML::Event()::POST()->Retrieve($login_form);
HTMLProc($user_entries);

$session = new Session();
$session->Start();

if (SUCCEEDED($_POST)) {

    $connection = ConnectDB();
    $prepared = new PreparedStatement($connection);

    $verify_member_crendentials = "SELECT m_password, m_account_state 
                                   FROM t_members
                                   WHERE m_email = ? AND m_password = ?";

    $prepared->QueryObject($verify_member_crendentials, $user_entries);
    $prepared->Statement();

    $record = $prepared->Statement();

    if ($record->RowCount > 0)

        $row = $record->SelectRows();
            
            if ($row['m_account_state'] == 'active')
                echo "Login successful"

            redirect('https://example.com/feed/')

            else echo "Your account is not active"

    else echo "Invalid email or password"

    DisconnectDB($connection);

}
?>