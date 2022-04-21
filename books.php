<?php
include_once 'header.php';
include_once 'helpers/session_helper.php';
include_once 'models/Book.php';
include_once 'models/Settings.php';

$book = new Book(); # raamatu objekt
$books = $book->getBooks(); # raamatud objektina
//show($books);
?>
<div class="container-fluid">
    <div class="row">
        <div>
            <h1 class="text-center mt-5">
                TOP 100 Rahva Raamatut 2021. aastal
            </h1>
            <?php
            if($books) {
                ?>
                <div class="container-fluid">
                <table class="table table-responsive table-hover table-bordered border-default">
                    <thead class="text-center">
                        <tr>
                            <th>Jrk</th>
                            <th>Raamatu nimi</th>
                            <th>Autor</th>
                            <th>Hinnang
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $settings = new Settings();
                        $enabled = $settings->getAllowChangeRating();
                        $readonly = true; // true ehk 1 ehk EI SAA MUUTA
                        $userEmail = ''; // kasutaja pole sisse loginud
                        $setting = $enabled->allow; // $setting on kas 1 või 0
                        $book_ids = array();
                        // Kontrolli kas kasutaja on sisse logitud
                        if(isset($_SESSION['usersEmail'])) {
                            if($enabled->allow) {
                                $readonly = false; // false ehk 0 ehk SAAB MUUTA
                            }
                            $userEmail = $_SESSION['usersEmail'];
                            $book_ids = $book->getRatedUserBooksIds($userEmail);
                            //show($book_ids);
                        }
                        foreach($books as $key=>$val) {
                            ?>
                            <tr>
                                <td class="text-end"><?php echo $key+1; ?></td>
                                <td><?php echo $val->book_name; ?></td>
                                <td><?php echo $val->book_author; ?></td>
                                <td>
                                    <div class="my-rating text-center" id="<?php echo $val->id; ?>"></div>
                                    <?php 
                                    $found = false; // kirjet pole
                                    if(is_array($book_ids) && count($book_ids) > 0) {
                                        foreach($book_ids as $k=>$v) {
                                            if($val->id == $v->book_id) {
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
                                                    url: 'setBookValue.php',
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