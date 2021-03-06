<?php
/*Copyright (C) 2013 Jarosław Stasiaczek
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, 
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Base and Default target class that allow to display CUploader without Tinymce just as standalone page
 *
 */
class Ciap_Target{
	protected static $instance = Array();
	
	protected function __construct() {
		
	}
	
	/**
	 * Create instance of Ciap_Target
	 * @param string $class
	 * @return Ciap_Target
	 */
	public static function getInstance($class = null)
	{
		if(empty($class) && isset($_REQUEST['target']))
		{
			$target = ucfirst(strtolower($_REQUEST['target']));
			if(class_exists('Target_'.$target))
			{
				$class = 'Target_'.$target;
				Ciap_Url::setTarget($target);
			}
			elseif('Ciap_Target' == 'Ciap_'.$target)
			{
				$class='Ciap_'.$target;
				Ciap_Url::setTarget($target);
			}
		}
		if(empty($class))
			$class = Config::getInstance()->target;
		
		if(isset(self::$instance[$class]))
			return self::$instance[$class];
		
		self::$instance[$class] = new $class();
		return self::$instance[$class];
	}
	
	/**
	 * Init all needed data, used by class loader
	 */
	public function preInit()
	{
		Ciap_Script::getInstance()->registerScript('target', '/public/js/target/default.js');
	}
	
	/**
	 * Is possible to insert images by this target
	 * @return boolean
	 */
	public function canInsertImages()
	{
		return false;
	}
	/**
	 * Return json array that is passed to target javascript class
	 * @return string
	 */
	public function getJsParams()
	{
		return '{}';
	}
}

?>
