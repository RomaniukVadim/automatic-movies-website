<?php

class Rcl_PageNavi{
    public $current_page = 1;
    public $pages_amount;
    public $output_number = array(4,4);
    public $in_page = 30;
    public $key = 'rcl-page';
    public $data_amount = 0;
    public $uri = array();
    public $pager_id;
    public $custom = array();
    public $offset;
    public $ajax = false;
    
    function __construct($pager_id,$data_amount,$custom = array()){

        $this->pager_id = $pager_id;
        
        if(isset($_GET['pager-id'])&&$_GET['pager-id']==$this->pager_id){
            $this->current_page = $_GET[$this->key];
        }
        
        $this->data_amount = $data_amount;        
        $this->custom = $custom;
        
        if($this->custom){
            if(isset($this->custom['in_page'])) 
                $this->in_page = $this->custom['in_page'];
            
            if(isset($this->custom['key'])){ 
                $this->key = $this->custom['key'];
                if(isset($_GET[$this->key]))
                    $this->current_page = $_GET[$this->key];
            }
            
            if(isset($this->custom['current_page'])) 
                $this->current_page = $this->custom['current_page'];
            
            if(isset($this->custom['output_number'])) 
                $this->output_number = $this->custom['output_number'];
            
            if(isset($this->custom['ajax'])) 
                $this->ajax = $this->custom['ajax'];
        }
        
        if($this->current_page==0)
            $this->current_page = 1;

        $this->offset = ($this->current_page-1)*$this->in_page;
        $this->pages_amount = ceil($this->data_amount/$this->in_page);
        
        $this->uri_data_init();
    }
    
    function uri_data_init(){
        
        $this->uri['current'] = (defined( 'DOING_AJAX' ) && DOING_AJAX && isset($_POST['tab_url']))? $_POST['tab_url']: get_bloginfo('wpurl').str_replace('?'.$_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
        
        if($_SERVER['QUERY_STRING']){
            $strings = explode('&',$_SERVER['QUERY_STRING']);
            foreach($strings as $string){
                $query = explode('=',$string);
                $this->uri['args'][$query[0]] = $query[1];
            }
        }
        
        unset($this->uri['args'][$this->key]);
        unset($this->uri['args']['pager-id']);
        
        $str = array('pager-id='.$this->pager_id);
        
        if($this->uri['args']){
            foreach($this->uri['args'] as $k=>$val){
                $str[] = $k.'='.$val;
            }
        }
        
        $this->uri['string'] = implode('&',$str);
    }
    
    function limit(){
        return $this->offset.','.$this->in_page;
    }
    
    function pager_query(){
        $query = array();
        
        $query['args']['number_left'] = (($this->current_page - $this->output_number[0])<=0)? $this->current_page - 1: $this->output_number[0];
        $query['args']['number_right'] = (($this->current_page + $this->output_number[1])>$this->pages_amount)? $this->pages_amount - $this->current_page: $this->output_number[1];

        if($query['args']['number_left']){
            
            $start = $this->current_page-$query['args']['number_left'];
            
            if($start>1){
                $query['output'][]['page'] = 1;
            }
            
            if($start>2){
                $query['output'][]['separator'] = '...';
            }
                
            
            for($num=$query['args']['number_left'];$num>0;$num--){
                $query['output'][]['page'] = $this->current_page-$num;
            }
        }
        
        $query['output'][]['current'] = $this->current_page;
        
        if($query['args']['number_right']){
            for($num=1;$num<=$query['args']['number_right'];$num++){
                $query['output'][]['page'] = $this->current_page+$num;
            }
            
        }
        
        $end = $this->pages_amount-($this->current_page+$query['args']['number_right']);
        
        if($end>1)
            $query['output'][]['separator'] = '...';
        
        if($end>0)
            $query['output'][]['page'] = $this->pages_amount;
        
        
        return $query;
    }
    
    function get_url($page_id){ 
        if($this->ajax) return '#';
        return rcl_format_url($this->uri['current']).$this->uri['string'].'&'.$this->key.'='.$page_id;
    }
    
    function pagenavi($classes = ''){
        
        if(!$this->data_amount||$this->pages_amount==1) return false;
        
        $query = $this->pager_query();
        
        $class = 'rcl-pager';
        
        if($classes) $class .= $class.' '.$classes;
        
        if($this->ajax) $class = $class.' rcl-ajax-navi';
        
        $content = '<div class="'.$class.'">';
        
            $content .= '<div class="rcl-page-navi">';

            foreach($query['output'] as $item){
                foreach($item as $type=>$data){
                    if($type=='page'){
                        $html = '<a href="'.$this->get_url($data).'" data-page="'.$data.'">'.$data.'</a>';
                    }else if($type=='current'){
                        $html = '<span data-page="'.$data.'">'.$data.'</span>';
                    }else{
                        $html = '<span>'.$data.'</span>';
                    }
                    $content .= '<span class="pager-item type-'.$type.'">'.$html.'</span>';
                }
            }

            $content .= '</div>';
        
        $content .= '</div>';
        
        return $content;
    }
}