<?php
spl_autoload_register(null, false);
spl_autoload_extensions('.php, .class.php');

//Portal share common class under <portal>/classes must register here 
function classesLoader($class)
{
	$file = __DIR__.'/classes/'. $class. '.php'; 


	if (!file_exists($file))
      {
          
          return false;

       }
       include $file;
}
spl_autoload_register('classesLoader');

//Portal share data model under <portal>/model must register here 
function modelLoader($class)
{

	$file = __DIR__.'/model/'. $class. '.php'; 

    if (!file_exists($file))
    {
        return false;
    }
    include $file;
}
spl_autoload_register('modelLoader');

?>