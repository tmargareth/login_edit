<?php
include_once 'headerMouth.php';
include_once 'helpers/session_helper.php';
include_once 'models/Mouth.php';
include_once 'models/SettingsMouth.php';

$mouth = new Mouth(); # raamatu objekt
$mouths = $mouth->getMouth(); # raamatud objektina
//show($mouths);
?>
<div class="container-fluid">
    <div class="row">
        <div>
            <h1 class="text-center mt-5">
                Lapsesuu ei valeta
            </h1>
            <?php
            if($mouths) {
                ?>
                <div class="container-fluid">
                <table class="table table-responsive table-hover table-bordered border-default">
                    <thead class="text-center">
                        <tr>
                            <th>Jrk</th>
                            <th>Tekst</th>
                            <th>Hinnang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $settings = new SettingsM();
                        $enabled = $settings->getAllowChangeRatingToMouth();
                        $readonly = true; // true ehk 1 ehk EI SAA MUUTA
                        $userEmail = ''; // kasutaja pole sisse loginud
                        $setting = $enabled->allow; // $setting on kas 1 või 0
                        $mouth_ids = array();
                        // Kontrolli kas kasutaja on sisse logitud
                        if(isset($_SESSION['usersEmail'])) {
                            if($enabled->allow) {
                                $readonly = false; // false ehk 0 ehk SAAB MUUTA
                            }
                            $userEmail = $_SESSION['usersEmail'];
                            $mouth_ids = $mouth->getRatedUserMouthIds($userEmail);
                            //show($mouth_ids);
                        }
                        foreach($mouths as $key=>$val) {
                            ?>
                            <tr>
                                <td class="text-end"><?php echo $key+1; ?></td>
                                <td><?php echo $val->child_text; ?></td>
                                <td>
                                    <div class="my-rating text-center" id="<?php echo $val->id; ?>"></div>
                                    <?php 
                                    $found = false; // kirjet pole
                                    if(is_array($mouth_ids) && count($mouth_ids) > 0) {
                                        foreach($mouth_ids as $k=>$v) {
                                            if($val->id == $v->mouth_id) {
                                                $found = true;
                                            }
                                        }
                                    }
                                    if(empty($userEmail)) { // pole sisse loginud
                                        $readonly = true; // ei saa muuta
                                    } else if (!$found) { // raamatut ei leitud nimekirjast
                                        $readonly = false; // saab muuta
                                    } else if ($found && !$setting) { // leiti ja seadistus ei luba muuta
                                        $readonly = true; // ei saa muuta
                                    }
                                    ?>
                                    <script>
                                        readonly = <?php echo json_encode($readonly); ?>;
                                        useremail = <?php echo json_encode($userEmail);  ?>;
                                        $(".my-rating").starRating({
                                            starSize: 25,
                                            initialRating: <?php echo $val->rating; ?>,
                                            readOnly: readonly,
                                            callback: function(currentRating, $el) {
                                                let rate = currentRating; // mitme tärniga hinnati
                                                let id = $el[0].id; // raamatu ID
                                                //console.log(rate, id, useremail)
                                                $.ajax({
                                                    type: 'POST',
                                                    url: 'setMouthValue.php',
                                                    //dataType: 'JSON',
                                                    data: {
                                                        id: id,
                                                        rate: rate,
                                                        uemail: useremail
                                                    },
                                                    success: function(data) {
                                                        //$("#class-list").html(data);
                                                        console.log('Rating updated');
                                                        //console.log(data);
                                                        location.reload(true);
                                                    },
                                                    error: function(data) {
                                                        console.log('Rating error');
                                                        //console.log(data);
                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>