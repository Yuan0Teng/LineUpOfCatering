<?php
require_once dirname(__FILE__)."/../utils/CRUDdatabase.php";

$operator  = isset($_POST["operator"])?$_POST["operator"]:null;
$data_json = isset($_POST["data"])?$_POST["data"]:null;
//var_dump($data_json);
$data = json_decode($data_json,true);
//var_dump($data);
if(!is_array($data)){
    die("[{result:false},{[]}]");
}
$crud      = new CRUDdatabase();

switch ($operator){
    case "notice":
        if(notice($crud,$data))
            echo "true";
        else
            echo "false";
        break;
    case "cancel":
        if(cancel($crud,$data))
            echo "true";
        else
            echo "false";
        break;
    case "add":
        if(add($crud,$data))
            echo "true";
        else
            echo "false";
        break;
    default:
        break;
}

function notice(CRUDdatabase $crud,$data){
    if(!is_array($data)){
        return false;
    }
    $id = $data["id"];
    $crud->updateDatabase($id,1);//已发短信
    return true;
}
function cancel(CRUDdatabase $crud,$data){
    if(!is_array($data)){
        return false;
    }
    $id = $data["id"];
    $crud->updateDatabase($id,4);//取消排队
    return true;
}
function add(CRUDdatabase $crud,$data){
    if(!is_array($data)){
        return false;
    }
    $cell_phone = $data["cellPhone"];
    $cstmr_name = $data["cstmrName"];
    $size       = $data["size"];
    $status     = 0;//未发短信 正在排队
    $crud->insertToDatabase($cell_phone,$cstmr_name,$size,$status);
    return true;
}
