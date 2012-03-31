<?php

	define('DS', preg_match('/\//', __DIR__) ? '/' : '\\');
	define('BASE_PATH', __DIR__.DS.'..'.DS);
	$_CLASSES = array(
		// data types
		'Zeus_Array'    => BASE_PATH.DS.'lib'.DS.'Types'.DS.'Array.php',
		'Zeus_Object'   => BASE_PATH.DS.'lib'.DS.'Types'.DS.'Object.php',
		'Zeus_String'   => BASE_PATH.DS.'lib'.DS.'Types'.DS.'String.php',
		
		// files
		'Zeus_File'     => BASE_PATH.DS.'lib'.DS.'Files'.DS.'File.php',
		'Zeus_Image'    => BASE_PATH.DS.'lib'.DS.'Files'.DS.'Image.php',
		'Zeus_Mp3'      => BASE_PATH.DS.'lib'.DS.'Files'.DS.'Mp3.php',
		'Zeus_Txt'      => BASE_PATH.DS.'lib'.DS.'Files'.DS.'Txt.php',
		'Zeus_Upload'   => BASE_PATH.DS.'lib'.DS.'Files'.DS.'Upload.php',
		'Zeus_Zip'      => BASE_PATH.DS.'lib'.DS.'Files'.DS.'Zip.php',
		'Zeus_Dir'      => BASE_PATH.DS.'lib'.DS.'Files'.DS.'Dir.php',
		
		// database
		'Zeus_Database' => BASE_PATH.DS.'lib'.DS.'Database'.DS.'Database.php',
		
		// helpers
		'Zeus_Class'    => BASE_PATH.DS.'lib'.DS.'Class.php',
		'Zeus_Mailer'    => BASE_PATH.DS.'lib'.DS.'Mailer'.DS.'Mailer.php',
		
		// application
		'Zeus_Event'    => BASE_PATH.DS.'lib'.DS.'Event.php',
		'Zeus_Error'    => BASE_PATH.DS.'lib'.DS.'Error.php',
		'Zeus_Config'   => BASE_PATH.DS.'lib'.DS.'Config.php',
		'Zeus_Document' => BASE_PATH.DS.'lib'.DS.'Document.php',
		'Zeus_Factory'  => BASE_PATH.DS.'lib'.DS.'Factory.php',
		'Zeus_Request'  => BASE_PATH.DS.'lib'.DS.'Request.php'
	);
	
	require BASE_PATH.DS.'lib'.DS.'import.php';
	require BASE_PATH.DS.'lib'.DS.'autoload.php';
	
	$db = Zeus_Factory::getDBO();
	$db->setQuery("SELECT class_name, class_file FROM #__extends ORDER BY class_id ASC");
	$db->query();
	if($db->getNumRows()){
		foreach($db->loadObjectList() as $item){
			if(isset($_CLASSES[$item->class_name]))
				Zeus_Error::raise("Core: Existem duas ou mais classes com o mesmo nome, {$item->class_name}");
			$_CLASSES[$item->class_name] = BASE_PATH.DS.'lib'.DS.'Classes'.DS.$item->class_file;
		}
	}
	
?>