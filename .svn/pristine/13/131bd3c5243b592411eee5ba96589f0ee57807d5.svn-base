<?php
class Page{
    private $__totalPageNum;        //总页数/最后一页的页码
    private $__totalRowNum;         //总行数
    private $__pageRowNum;          //一页的行数
    private $__currentPageNum;      //当前页码
    
    private static $__instance;     //单例模式的实例
    
    private function __construct(){
        
    }
    /**
    返回mysql limit需要的第一个参数,即数据库记录开始的行数,如果数据库是mysql
    则非常方便mysql limit 第一个参数是从0 开始计数的
    */
    public function getLimitFirstNum(){
        if($this->__pageRowNum >= $this->__totalRowNum)
            return 0;
        $result = ( ($this->__currentPageNum-1) * $this->__pageRowNum );;
        //echo __FILE__ . __LINE__  .  " res= $result |" . " $this->__currentPageNum" .'<br>';
        return $result;
    }
    
    public function getTotalPageNum(){
        return $this->__totalPageNum;
    }
    
    public function getCurrentPageNum(){
        return $this->__currentPageNum;
    }
    //初始化单实例,或者修改单实例的方法
    public function init($totalRowNum,$pageRowNum=1){
        $this->__totalRowNum = $totalRowNum;
        $this->__pageRowNum = $pageRowNum;
        $this->__currentPageNum = 1;//设定当前页码为 第一页
        if($pageRowNum==0)
            return;
        if ($this->__totalRowNum % $this->__pageRowNum!=0){ 
            $this->__totalPageNum=
                sprintf("%d",$this->__totalRowNum/$this->__pageRowNum)+1; 
        }else{ 
            $this->__totalPageNum=$this->__totalRowNum / $this->__pageRowNum;
            //echo __FILE__ . __LINE__ . "TOTAL=" . $this->__totalRowNum ."rownum=".$this->__pageRowNum.'<br>';
            //echo __FILE__ . __LINE__ . "curpage = $this->__currentPageNum";
        }
    }
    public function nextPage(){
        if ($this->__currentPageNum>=$this->__totalPageNum){
            return $this->__totalPageNum;
        }
        return ++$this->__currentPageNum;
        
    }
    public function prevPage(){
        if ($this->__currentPageNum<=1){
            return 1;
        }
        return --$this->__currentPageNum;
    }
    public function toPage($page_num){
        if($page_num<1){
            $this->__currentPageNum = 1;
        }else if($page_num>$this->__totalPageNum){
            $this->__currentPageNum = $this->__totalPageNum;
        }else{
            $this->__currentPageNum = $page_num;
        }
    }
    /**
    得到实例,很经典
    */
    public static function getInstance(){
        if(! (self::$__instance) instanceof self){
            self::$__instance = new self;
        }
        return self::$__instance;
    }
    /**
    防止克隆对象
    */
    public function __clone(){
        trigger_error('Clone Page is not allow!',E_USER_ERROR);
    }
}
?>