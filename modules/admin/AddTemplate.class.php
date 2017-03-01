<?php
namespace Modules\Admin;

class AddTemplate  extends Admin {

	
	public function run() {
		
		$this->setTplName("web/template/add_new.tpl");
		$this->render();
	}




}
