<?php session_start();
    include('../lib/conexions.php');
    if ($_GET['action']=='addsv') {
        $data = json_decode(file_get_contents("php://input"));
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        $fp = fopen("../pdf/seriegmz.txt", "w");
        fwrite($fp, ($data->num).PHP_EOL);
        fclose($fp);
        echo "ok";
    }
    else{
        if ($_GET['action']=='get') {
            $fp = fopen("../pdf/seriegmz.txt", "r");
            $valorv = (int) fgets($fp);
            fclose($fp);

            $fp = fopen("../pdf/serieserv.txt", "r");
            $valors = (int) fgets($fp);
            fclose($fp);

            $datos = array(
                'seve' => $valorv,
                'sese' => $valors,
            );
            echo json_encode($datos);
        }
        else{
            if ($_GET['action']=='addss') {
                $data = json_decode(file_get_contents("php://input"));
                error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
                $fp = fopen("../pdf/serieserv.txt", "w");
                fwrite($fp, ($data->num).PHP_EOL);
                fclose($fp);
                echo "ok";
            }
        }
    }
    $conn = null;
?>