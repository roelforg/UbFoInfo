<?php
class gui
{
public function go()
{
	$options = array(
	array("short"=>"Networking","long"=>"Your network/internet connection is experiencing problems.")
	);
	$result = dialog::display("What's your problem?","Please help and refine the problem by selecting a category.","menu",$options);
	if ($result===false)
		exit;
	var_dump($result);
}
};

