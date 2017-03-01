<?php
namespace Dragon;
/**
 * 所有的Action的基类，主要复杂初始化smarty
 * author gstan
 * date 2013-02-07
 * 474703907@qq.com
 */
class CModule {
	private $smarty;
	private $args;

	public function __construct() {
		$this->smarty = new \Smarty();
		$this->init();
	}

	public function init() {
		$this->smarty->template_dir = SMARTY_TMPDIR; 
        $this->smarty->compile_dir = SMARTY_TMPDIRC;
        $this->smarty->compile_check = TRUE;
        $this->smarty->caching = false;
        $this->smarty->cache_dir = SMARTY_CACHEDIR;
        $this->smarty->left_delimiter  =  SMARTY_DLEFT;
        $this->smarty->right_delimiter =  SMARTY_DRIGHT;
        $this->smarty->cache_lifetime = LIFTTIME;
	}

	//渲染模板
    protected function render() {
		if (!empty($this->tplParam)) {
			foreach ($this->tplParam as $key => $value) {
				$this->smarty->assign($key,$value);
			}   
		}
        $this->smarty->display( SMARTY_TMPDIR  . $this->tplName);
    }   

    //设置模板参数
    protected function setTplParam($key, $value) {
        $this->tplParam[$key] = $value;
    }   

    //设置模板名称
    protected function setTplName($strTplName) {
        $this->tplName = $strTplName;
    }
	public function run() {
		echo "welcome to meilishuo";
	}


}
