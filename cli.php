<?php
class cli
{
 public static $shortopts = "";
 public static $longopts =array();
 public static $cli_opts=array();
 public function init()
 {
	function addopt($opt)
	{
		cli::$longopts[]=$opt;
		cli::$shortopts=cli::$shortopts.substr($opt,0,1);
	}

	$elems=array(
	"help"=>"Display this menu"
	);

	foreach (array_merge(data::$elements,$elems) as $name=>$element)
		addopt($name);

	$options = getopt(cli::$shortopts, cli::$longopts);
	$realopts = array();
	foreach($options as $name=>$option)
	{
		foreach (cli::$longopts as $opt)
			if (substr($name,0,1)==substr($opt,0,1))
			{
				$name=$opt;
				break;
			}
		$realopts[$name]=$option;
	}
	cli::$cli_opts=$realopts;
	if (in_array("help",array_keys($realopts)))
	{
		foreach(array_merge(data::$elements,$elems) as $name=>$element)
			echo $name."\t\t\t".$element.PHP_EOL;
		exit(0);
	}
 }
 public function go()
 {
	cli::init();
	$cli_opts = cli::$cli_opts;
	$mode=-1;
	foreach ($cli_opts as $opt=>$val)
	{
		if (in_array($opt,array_keys(data::$elements)))
			$mode=$opt;
	}
	if ($mode === -1)
	{
		echo "No action!".PHP_EOL;
		exit(1);
	}
	subsys::run($mode);

	global $report;
	file_put_contents("./report.txt",$report->report);
 }
};

