<?php

function errorValidasi($array)
{
    $arr = json_decode($array, true);
    $pesan = '';
    foreach ($arr as $key => $val) {
        foreach ($val as $sub_val) {
            $pesan .= $sub_val . '<br>';
        }
    }
    return $pesan;
}

function errorMessage($msg)
{
    $param = (str_replace("\n", "", str_replace('"', "|", $msg)));
    if (strpos($param, 'Cannot add or update a child row: a foreign key constraint fails')) {
        return "Data tidak dapat diproses karena terelasi tidak sesuai!"; //  "<br> Msg : " . substr($param, 0, strpos($param, '(') - 1)
    } elseif (strpos($param, 'foreign key constraint fails')) {
        return "Data tidak dapat diproses karena terelasi dengan data lain!"; //  "<br> Msg : " . substr($param, 0, strpos($param, '(') - 1)
    } elseif (strpos(strtolower($param), 'value violates unique constraint')) {
        return "Data tidak boleh sama <br> Msg : " . $param;
    } elseif (strpos(strtolower($param), 'plicate entry')) {
        return "Data tidak boleh sama <br> Msg : " . $param;
    } else {
        return $param;
    }
}

function getPhoto($location_id)
{
    $file = glob(public_path('files') . "/$location_id*");
    if (count($file)) {
        $photo = $file[0];
    } else {
        $photo = public_path('images/user.png');
    }

    $data = fopen($photo, 'rb');
    $size = filesize($photo);
    $contents = fread($data, $size);
    fclose($data);
    return $contents;
}