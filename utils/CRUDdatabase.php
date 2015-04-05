<?php
    require_once 'linkToDatabase.php';

    class CRUDdatabase {
        public function insertToDatabase($cell_phone,$cstmr_name,$size,$status) {
            if (strlen($cell_phone) != 11 || $size > 20 || $size < 1) {
                die("input error");
            }
            $link = new linkToDatabase();
            $conn = $link->link();
            $sql  = "INSERT INTO line_up(cell_phone,cstmr_name,size,status)  values (?,?,?,?);";
            $pstmt = $conn->prepare($sql);
            if ($pstmt == null) {
                echo "Error: " . $sql . "<br>" . $conn->error;
                die('sql语法错误');
            }
            $pstmt->bind_param("ssii",$cell_phone,$cstmr_name,$size,$status);
            //$pstmt->bind_result($response);
            if (!$pstmt->execute() === TRUE) {
                $conn->close();
                return false;
            }
            $pstmt->close();
            $conn->close();
            return true;

        }

        public function deleteFromDatabase($id) {

            $link = new linkToDatabase();
            $conn = $link->link();
            $sql = "delete from line_up where id = " . $id . ";";

            if ($conn->query($sql) === TRUE) {
//                echo "Delete successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }

        public function updateDatabase($id, $status) {//PASS
            
            $link = new linkToDatabase();
            $conn = $link->link();
            $sql = "UPDATE line_up SET status = ".$status." WHERE id =". $id.";";

            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }

        public function getDataFromDatabase($id) {
            if (strlen($id) != 11) {
                die("input error");
            }

            $link = new linkToDatabase();
            $conn = $link->link();
            $sql = "select cell_phone, cstmr_name,  size ,status  from line_up where id = " . $id . ";";

            if ($conn->query($sql) === TRUE) {
//                echo "Update successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }

        public function getPageDataFromDatabase($start,$rows) {//PASS
            if(!(is_numeric($start) && is_numeric($rows))){
                die("分页查询参数不是整数!");
            }
            $link = new linkToDatabase();
            $conn = $link->link();
            $sql = "select id,cell_phone, cstmr_name, size from line_up where status=0 limit $start , $rows;";
            $pstmt = $conn->prepare($sql);
            if ($pstmt == null) {
                echo "Error: " . $sql . "<br>" . $conn->error;
                die('sql语法错误');
            }
            $pstmt->bind_result($id, $cell_phone, $cstmr_name,$size);
            if (!$pstmt->execute() === TRUE) {
                $conn->close();
                return false;
            }
            $rows_data = array();//保存结果集
            while ($pstmt->fetch()) {
                $row = array("id"=>$id,"cell_phone"=>$cell_phone,"cstmr_name"=>$cstmr_name,"size"=>$size);
                array_push($rows_data, $row);
            }
            $pstmt->close();
            $conn->close();
            return $rows_data;
        }

        /**
         * @param $tableName string ,the table name from DB.
         * @return int ,the result of count table.If table not exist,function will return zero.
         * 查询数据库中某个表的记录综总数,一般用于分页.
         */
        public function getTableCount($tableName){//PASS
            $link = new linkToDatabase();
            $conn = $link->link();
            $sql = "SELECT COUNT(*) AS row_count from $tableName;";
            $pstmt = $conn->prepare($sql);
            //$pstmt->bind_param("s", $tableName);
            $pstmt->bind_result($row_count);
            if ($pstmt->execute() === TRUE) {
                while ($pstmt->fetch()) {
                }
                $pstmt->close();
                $conn->close();
                return $row_count;
            }
            $pstmt->close();
            $conn->close();
            return 0;
        }

    }
/*
$test = new CRUDdatabase();
$result = json_encode($test->getPageDataFromDatabase(1,10));
echo $result;*/
//$test = new CRUDdatabase(); $result = $test->getTableCount("line_up");echo $result;