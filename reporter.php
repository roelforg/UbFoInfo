<?php
class reporter {
public $report="";
public $level=0;
public function enter_section($section)
{
	$report=&$this->report;
	/*$mlen=strlen($section);
	for ($i=0;$i<((80/2)-($mlen/2))-2;$i++)
		echo "=";
	echo "> ".$section." <";
	for ($i=2;$i<=((80/2)-($mlen/2));$i++)
		echo "=";
	echo PHP_EOL;*/
	$this->level++;
	for ($i=0;$i<$this->level;$i++)
		$report.="=";
	$report.=">".$section.PHP_EOL;
}
public function exit_section($section)
{
	$this->level--;
}
public function add($content)
{
	$this->report.=$content.PHP_EOL;
}

}

$report = new reporter();

