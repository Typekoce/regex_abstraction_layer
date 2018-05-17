<?php

class Regex {
	
	public $config;
	
	public $space = '\s';
	
	public $preceding = '?';
	
	public $backspace = '\b';
	
	public $backslash = '\B';
	
	public $caret = '^';
	
	public $pipe = '|';
	
	public $line_break = '\R';
	
	public $alert = '\a';
	
	public $escape = '\e';
	
	public $form_feed = '\f';
	
	//TODO: [0-9]
	public $zero_to_nine = '\d';
	
	// TODO: [A-Za-z0-9_]
	public $word_character = '\w';
	
	public $tab = '\t';
	
	public $hyphen = '-';
	
	//TODO: \(?(\d{3})\)?[\s-]?(\d{3})?(\d{4})
	
	public function __construct($config=false){
		
		$this->config=$config;
		
		$this->init();
		
	}
	
	public function square($contents,$options=false){
		
		return '[' . $contents . ']';
		
	}
	
	public function delimiter($contents,$options=false){
		
		return '/' . $contents . '/';
		
	}
	
	public function range($data=false,$options=false){
		
		$range = 3;
		
		if(isset($options['range'])){
			
			$range = $options['range'];
			
		}
			
		$item = $this->preceding;
		
		$contents = $this->zero_to_nine;
		
		$contents .= $this->braces($range);
		
		$item .= $this->brackets($contents);
		
		//$item .= $this->preceding;
		
		return $item;
		
	}
	
	public function contains($data=false,$options){
		
		$item = '';
		
		$contents = 'ae';
		
		$item = $this->square($contents);
		
		return $item;
	}
	
	public function number_sequence($data,$options){
		
		$item = $this->sequence();
				
		return $item;
	}
	
	public function sequence($data=false,$options=false){
		
		$item = $this->braces(3);
		
		$item = $this->zero_to_nine . $item;
		
		$item = $this->brackets($item);
		
		$item = $this->preceding . $item;
		
		$item = $this->ebrackets($item);
		
		$item .= $this->preceding;
		
		$contents = $this->space . $this->hyphen;
		
		$contents = $this->square($contents);
		
		$item .= $contents;
		
		$item .= $this->range();
		
		$opts = array(
			'range'=>4
		);
		
		$item .= $contents;
		
		$item .= $this->range('',$opts);
		
		$item = $this->delimiter($item);
		
		return $item;
		
	}
	
	public function braces($contents,$options=false){
		
		return '{' . $contents . '}';
		
	}
	
	public function brackets($contents,$options=false){
		
		return '(' . $contents . ')';
		
	}
	
	public function ebrackets($contents,$options=false){
		
		return '\(' . $contents . '\)';
		
	}
	
	public function lookback($string,$start,$opts=false){
		
		$it = new ArrayIterator($opts);
		
		$it = new CachingIterator($it);
		
		$conditions = "";
		
		foreach ($it as $elm) {
			
			if($it->hasNext()){
				
				$conditions .= $it->current() . $this->pipe;
				
			} else {
				
				$conditions .= $it->current();
				
			}
			
		}
		
		$regex = '/' . $start . '(' . $conditions . ')?/';
		
		$match = preg_match($regex, $string);
		
		if($match){
			
			return TRUE;
			
		} else {
			
			return FALSE;
			
		}
				
	}
	
	public function init($config=false){
		
		//$this->simple_match();
		
	}
	
	public function simple_match($data=false){
		
		$subject="I am #test and #example1";
		
		$pattern="/#+([a-zA-Z0-9_]+)/";
		
		$ubject=preg_replace($pattern, "$0", $subject);
						
	}
	
	public function stylesheet_select($data,$options){
		
		$ele = 'selector';
		
		$select = $options[$ele] . ' {(.*)}';
		
		$pattern='#' . $select .'#Us';
					
		$subject=$data['style_get'];
		
		preg_match_all($pattern, $subject,$matches,PREG_SET_ORDER);
		
		if(isset($matches[0][1])){
			
			$rs = array(
				$options[$ele] => $matches[0][1]
			);
			
			$data[__FUNCTION__][] = $rs;
			
		}
		
			
		return $data;
	}
	
	public function selector_get($data,$options){
		
		$ele = 'selector';
				
		$select = $options[$ele] . ' {(.*)}';
		
		$pattern='#' . $select .'#Us';
				
		$subject=$data['style_get'];
		
		preg_match_all($pattern, $subject,$matches,PREG_SET_ORDER);
		
		if(isset($matches[0][1])){
						
			$rs = array(
				$options[$ele] =>$matches[0][1]
			);
			
			
			$data['selector_get'][] = $rs;
		}
		
		return $data;
	}
	
}

?>