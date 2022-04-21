<?php
include_once 'models/Mouth.php';

//Võtame vormilt info
$id = $_POST['id'];
$rate = $_POST['rate'];
$uemail = $_POST['uemail'];

$mouth = new Mouth();
$isRated = $mouth->findRatedMouthByIdAndEmail($id, $uemail);
if(!$isRated) { // pole veel hinnatud
    $mouth->addUserNewRatingToMouth($id, $rate, $uemail);
} else {
    $mouth->updatedUserRatingToMouth($id, $rate);
}