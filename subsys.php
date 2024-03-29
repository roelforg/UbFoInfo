<?php
class subsys
{
public static $script_cat = <<< SCRIPT
networking:	networking	sysinfo
gfx:	sysinfo
SCRIPT;
 public function init()
 {
 }
 function exec($cmd)
 {
	$descriptorspec = array(
		0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
		1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
		2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
	);

	$cwd = '/tmp';
	$env = array('some_option' => 'aeiou');

	$process = proc_open('php', $descriptorspec, $pipes, $cwd, $env);

	if (is_resource($process)) {
	    // $pipes now looks like this:
	    // 0 => writeable handle connected to child stdin
	    // 1 => readable handle connected to child stdout
	    // Any error output will be appended to /tmp/error-output.txt
	
	    fwrite($pipes[0], '<?php print_r($_ENV); ?>');
	    fclose($pipes[0]);

	    echo stream_get_contents($pipes[1]);
	    fclose($pipes[1]);

	    // It is important that you close any pipes before calling
	    // proc_close in order to avoid a deadlock
	    $return_value = proc_close($process);

	    echo "command returned $return_value\n";
}
 }

 function run($category)
 {
	global $report;
	subsys::init();
	$lists = preg_split("/[\\n|\\r]/",subsys::$script_cat);
	$deps=array();
	foreach($lists as $list)
	{
		if (strlen($list)===0)
			continue;
		$list = explode(":\t",$list,2);
		$list[1] = explode("\t",$list[1]);
		$deps[]=$list;
	}
	$dep = array();
	foreach ($deps as $tmp)
		if ($tmp[0]==$category)
			$dep=$tmp;
	$file_list=array();
	$d = dir("subsys");
	while (false !== ($entry = $d->read()))
		foreach($dep[1] as $cat)
			if ((!($entry==="."))&&(!($entry==="..")))
			{
				if (preg_match("/^[0-9][0-9]-".$cat."---.*$/",$entry))
					$file_list[]=$entry;
			}
	$d->close();

	//sort files and process the files
	foreach ($dep[1] as $cat)
	{
		$files=array();
		foreach (preg_grep("/^[0-9][0-9]-".$cat."---.*$/",$file_list) as $file)
			$files[(int)substr($file,0,2)]=$file;
		ksort($files);
		//now process it
		$report->enter_section($cat);
		foreach ($files as $file)
		{
			$report->enter_section(substr($file,strpos($file,"---")+3));
			$code = rtrim(file_get_contents("subsys/".$file));
			$report->add(shell_exec("/bin/bash subsys/".$file));
			$report->exit_section(substr($file,strpos($file,"---")+3));
		}
		$report->exit_section($cat);
	}
 }
};

