<?php
namespace   Modules\Welcome;
use Dragon\CModule;

class Welcome extends CModule  {

		public function run() {
			$command = "cd /Users/gstan/coding/php/daily/; php 11.php & ";
			exec($command);
		}




}
