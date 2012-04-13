<?php
require_once("nDialog.class.php");
class dialog
{
/*
$options
|\_short  =string  <== Short description
|\_long   =string  <== Long description
\__initial=bool    <== Initial state
*/
public function display($title,$text,$mode,$options)
{
	$Dialog = new nDialog();
	// Set a top title bar
	$Dialog->set("title_page_header", " UbFoInfo V0.1 Alpha ");
	$Dialog->set("title_dialog_header", " $title ");
	$Dialog->set("text",$text);
	$Dialog->mode($mode, "25x80");
	switch ($mode)
	{
		case "checklist":
		$i=0;
		foreach ($options as $option)
		{
			$Dialog->addChecklist($i,$option["short"],substr(strtoupper($option["short"]),0,1), $option["long"],$i,((int)$option["state"])."");
			$i++;
		}
		break;

		case "menu":
		$i=0;
		foreach ($options as $option)
		{
			$Dialog->addMenu($option["short"],substr(strtoupper($option["short"]),0,1), $option["long"],$i);
		}
		break;
	}
	// Show dialog box & get user input
	$result = $Dialog->stroke();
	// Properly cleanup the screen
	$Dialog->distroy();
	return $result;
}
};

