<?php

if(!isset($_POST['data'])){
    die();
}
$data = $_POST['data'];

function run_code($data)
{
    try {
        ob_start();
        eval('?>' . $data);
        $reponse['result'] = ob_get_contents();
        ob_end_clean();
        $reponse['success'] = true;
        return $reponse;
    } catch (Throwable $e) {
        $reponse['success'] = false;
        $reponse['result'] = 'Caught exception: ' . $e->getMessage();
        return $reponse;
    }
}

$reponse = run_code($data);

$json = json_encode($reponse);

header('Content-Type: application/json');

echo $json;
