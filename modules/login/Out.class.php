<?php
namespace Modules\Login;

class Out {

	public function run() {
		session_destroy();
		header("location:/admin");
	}





}
