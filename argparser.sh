#!/bin/bash

function printHelp()
{
 echo "Help:";
 echo "Synopsis: $MAINSCRIPT [--network/-n] [--gfx] [--help/-h/-?]";
 echo "";
 echo -e "--help/-h/-?\t\t\tPrint this help and exit";
 echo -e "--network/-n\t\t\tDiagnose network problems";
 echo -e "--gfx\t\t\t\tDiagnose graphical problems";
 echo -e "--common/--nocommon\t\tApply trivial fixes (will be reversed if failed)"
}

#jam it with the anti-namespaces
function args::parse()
{
 for opt in "$GLOBARG"
 do
  case "$opt" in

  (--network|-n)
   OPERATION=network
   break
  ;;

  (--gfx)
   OPERATION=gfx
   break
  ;;

  (--common)
   COMMON_FIX=true
   break
  ;;
  (--nocommon)
   COMMON_FIX=false
   break
  ;;

  #print help
  (-h|--help)
    printHelp;
    leave;
  ;;

  #catch all
  (-*)
  error "Unknown arg: $opt";
  printHelp;
  leave 1;
  ;;
  esac
 done
 if ! [ -n "$GLOBARG" ]
 then
  error "You need to give me something to do!";
  printHelp;
  leave 1;
 fi
}

