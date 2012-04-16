#!/usr/bin/php
<?php
/* UbFoInfo */
/* UbFoInfo is a program to provide good info to online communities and is tailor made for ubuntu */

?>
===========================
==> UbFoInfo V0.1 Alpha <==
===========================
<?

include "functions.php";

if ($argc>1)
{
	cli::go();
} else {
	gui::go();
}

exit(0);

