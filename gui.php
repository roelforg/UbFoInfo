<?php
class gui
{
public function go()
{
	$options = array();
	foreach (data::$elements as $element)
	{
		$options[]=array("short"=>$element[0],"long"=>$element[1]);
	}
	$result = dialog::display("What's your problem?","Please help and refine the problem by selecting a category.","menu",$options);
	if ($result===false)
		exit;
	var_dump($result);
}
};

