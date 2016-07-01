<?php
    if (file_exists("../public/img/prods/".$_POST['fot'])) {
        unlink("../public/img/prods/".$_POST['fot']);
    }
    echo "ok";
?>