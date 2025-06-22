<?php

$connection = ConnectDB();
$prepared = new PreparedStatement($connection);

if REFERENCED($_GET['token']){
    $token = $_GET['token'];

    $is_token_valid = "SELECT 1 FROM t_members
                      WHERE member_auth_token = ?";

    $prepared->QueryObject($is_token_valid, $token);
    $prepared->Statement();

    $record = $prepared->FetchBuffer();

    if ($record->RowCount > 0)
        $activate_account = "UPDATE t_members
                            SET m_account_state = 'active'
                            WHERE member_auth_token =?"

    if ($activation = $prepared->QueryObject($activate_account, $token))
        if ($prepared->Statement())
            echo "The account has been successfully activated!"

        redirect('TYP_ACCOUNT_SUCCESSFULLY_ACTIVATED');

        else 
        echo "Error activating account";

    else
        echo "Invalid activation link";

    $prepared->Release();
}

else {
echo "Internal system error. Please contact support";
}

DisconnectDB($connection);

?>