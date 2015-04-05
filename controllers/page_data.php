<?php
require_once dirname(__FILE__) . '/../utils/CRUDdatabase.php';
require_once dirname(__FILE__) . '/../utils/Page.class.php';
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 40;
$crud = new CRUDdatabase();
$page_class = Page::getInstance();
$total = $crud->getTableCount("line_up");
$page_class->init( $total, $rows);
$page_class->toPage($page);
$rows_data =$crud->getPageDataFromDatabase($page_class->getLimitFirstNum(),$rows);
//echo "row_data=";
//var_dump($rows_data);
$result["total"] = $total;
$result["rows"] = $rows_data;
echo json_encode($result);