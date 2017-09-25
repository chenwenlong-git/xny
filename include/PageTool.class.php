<?php

class PageTool {
    protected $total = 0;
    protected $perpage = 10;
    protected $page = 9;
    

    public function __construct($total,$page=false,$perpage=false) {
        $this->total = $total;
        if($perpage) {
            $this->perpage = $perpage;
        }

        if($page) {
            $this->page = $page;
        }
    }


    // 主要函数,创建分页导航
    public function show() {
        $cnt = ceil($this->total/$this->perpage);  // 得到总页数
        $uri = $_SERVER['REQUEST_URI'];

        $parse = parse_url($uri);
        


        $param = array();
        if(isset($parse['query'])) {
            parse_str($parse['query'],$param);
        }

        // 不管$param数组里,有没有page单元,都unset一下,确保没有page单元,
        // 即保存除page之外的所有单元
        unset($param['page']);
        
        $url = $parse['path'] . '?';
        if(!empty($param)) {
            $param = http_build_query($param);
            $url = $url . $param . '&';
        }
        
        
        // 下一个关键,就是计算页码导航
        $nav = array();
        $nav[0] = '<span class="page_now">' . $this->page . '</span>';


               
        for($left = $this->page-1,$right=$this->page+1;($left>=1||$right<=$cnt)&&count($nav) <= 5;) {
            
            if($left >= 1) {
                array_unshift($nav,'<a href="' . $url . 'page=' . $left . '">' . $left . '</a>');
                $left -= 1;
            }
            
            if($right <= $cnt) {
                array_push($nav,'<a href="' . $url . 'page=' . $right . '">' . $right . '</a>');
                $right += 1;
            }
        }
		//上一页,下一页的判断
		if($this->page==1){
			$shang1=1;
			$next1 =$this->page+1;
		}
		else if($this->page==$cnt){
			$next1 = $this->page;
			$shang1=$this->page-1;
		}
		else{	
			$shang1=$this->page-1;
			$next1 =$this->page+1;
		}	
		$shang = '<a href="' . $url . 'page=' . $shang1. '">上一页</a>';
		$next = '<a href="' . $url . 'page=' . $next1. '">下一页</a>';
		if($this->page==1) $shang="上一页  ";
		if($this->page==$cnt) $next="  下一页";
		
		$nav = implode('',$nav);//返回数组再拆成字符串
       	$nav =$shang.$nav.$next;
		
        
		return $nav;

    }

}



/*

分页类调用测试

new pagetool(总条数,当前页,每页条数);

show() 返回分页代码.

$page = $_GET['page']?$_GET['page']:1;

$p = new PageTool(20,$page,6);
echo $p->show();


*/


