<?php
/** 
 * 分页
 * @name Pages.php
 * @author yubing
 * @subpackage include
 */
 class pages {
	public  $size=10; //每页显示的条目数
	private  $total;         //总条目数
	private  $page;//当前页
	private  $subNum;  //每次显示的页数
	private  $pageTotal;  //总页数
	private  $link;//每个分页的链接
    public $start; //记录开始条目
    
	/**
	__construct是pages的构造函数.
	
      $total //必须,总共有多少条记录
    默认从$_GET['page'] 读取当前第几页    
	 @param array $options = array(
       'size' //每页显示多少条,默认显示20条
       'link' //链接的url地址
       'page' //当前第几页
       'subNum' //显示多少个分页
     );
	 */
	function __construct($total, $options=array()){
	      $this->size = isset( $options['size'] ) ? max(1,$options['size']) : 10 ;
	      $this->total= (int)$total; 
	      $this->page = is_numeric($_GET['page']) ? max(1,$_GET['page']) : max(1,@$options['page']);
	      $this->start = ($this->page-1)* $this->size;	
	      $this->subNum= isset( $options['subNum'] ) ? max(1,(int)$options['subNum']) : 10 ;
	      $this->pageTotal=ceil($this->total/$this->size);
	      //分页的连接地址
	      if (isset($options['link'])&&!empty($options['link'])){            
		     $this->link= $options['link'];            
	      } else {
		     $_GET['page']='_page_';
		     $this->link =  '?'.http_build_query($_GET);
	      }     
	      if($this->page > $this->pageTotal) {
		     $this->page = $this->pageTotal;
	      }
	}
	
	/**
	 * 用于按什么方式显示分页   
     @param string subType 
      example：   共4523条记录,每页显示10条,第1/453页 [首页] [上页] [下页] [尾页]
    当@subType=2的时候为经典分页样式
    example：   第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页]
	 */  
	function show($subType=1) {
        //当设置的每页记录数,小于总记录条数,直接返回空字符串
	      if ($this->size > $this->total) {
		  return '';
	      }
	      $action = 'show'.$subType;
	      return $this->$action();
	}
	/** 当前记录开始数**/
	public function start(){
		return ($this->page -1)* $this->size;
	}
	/**
	 * 构造经典模式的分页
	 * 第1/453页 首页 上一页 1 2 3 4 5 6 7 8 9 10 下一页 尾页
	 */
	private function show1() {
        $sub_page_str = '';
        
        $offset = ceil(($this->subNum/2) -1);
        $from = max($this->page - $offset, 1);
        $to = $from + $this->subNum - 1;

        if ($to > $this->pageTotal) {
            $from = max($this->pageTotal - $this->subNum + 1, 1);
            $to = $this->pageTotal;
        }
        $sub_page_str="第".$this->page."/".$this->pageTotal."页&nbsp;";
        if ($this->page > 1) {            
            $sub_page_str.="<a href='".$this->getLink(1)."'>&#39318;&#39029;</a> \n"; //首页
            $sub_page_str.="<a href='".$this->getLink($this->page-1)."'>&#19978;&#19968;&#39029;</a> \n"; //上一页
        }
      
        for ($i = $from; $i <= $to; $i++) {
            $sub_page_str .= $i == $this->page ? '<a class="active">' . $i . '</a> ' : "<a href=\"" .
                $this->getLink($i) . "\">$i</a> ";
        }

        if ($this->page < $this->pageTotal) {            
            $sub_page_str.="<a href='".$this->getLink($this->page+1)."'>&#19979;&#19968;&#39029;</a> \n";//下一页
            $sub_page_str.="<a href='".$this->getLink($this->pageTotal)."'>&#23614;&#39029;</a> \n"; //尾页
        }
        return $sub_page_str;  
    }
	
    private function getLink($page=1){
        return str_replace('_page_',$page,$this->link);
    }
 	
    private function show2(){
        $sub_page_str="共{$this->total}条记录,每页显示{$this->size}条,当前第".$this->page."/".$this->pageTotal."页&nbsp;";
        if($this->page > 1) {
            $sub_page_str.="<a href='".$this->getLink(1)."'>首页</a> \n";
            $sub_page_str.="<a href='".$this->getLink($this->page-1)."'>上一页</a> \n"; 
        } else {
            $sub_page_str.="首页 ";
            $sub_page_str.="上一页 ";
        }
        if ($this->page < $this->pageTotal) {            
            $sub_page_str.="<a href='".$this->getLink($this->page+1)."'>下一页</a> \n";
            $sub_page_str.="<a href='".$this->getLink($this->pageTotal)."'>尾页</a> \n"; 
        } else {
            $sub_page_str.='下一页';
            $sub_page_str.='尾页'; 
        } 
        return $sub_page_str;
    }
    //手机分页
    private function show3(){
	$sub_page_str='';
       if($this->page > 1) {
            
            $sub_page_str.="<a href='".$this->getLink($this->page-1)."'><上一页</a>"; 
        } else {
            //$sub_page_str.="上一页 ";
        }
        if ($this->page < $this->pageTotal) {            
            $sub_page_str.="<a href='".$this->getLink($this->page+1)."' style='float:right;'>下一页></a>";
        } else {
           // $sub_page_str.='下一页';
        } 
        return $sub_page_str;
	     
    }
}
/*
$cnt = 1024;
$o = array('size'=>10,'page'=>8);
$page = new Pages($cnt , $o);
$s = $page->show();
echo $s;
echo '<br />';  
echo $page->show(1);
*/

 
