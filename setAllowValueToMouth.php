<?php
include_once 'models/SettingsMouth.php';
$settings = new SettingsM();
$allow = $_POST['allow'];
$id = $_POST['id'];
if($settings->setAllowValueToMouth($id, $allow)) {
    echo 'Ok';
} else {
    echo 'Error';
}

?>