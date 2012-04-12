#!/bin/bash

function include()
{
 if [ -n "$1" ] && [ -f "$TOPDIR/$1" ]
 then
  source $TOPDIR/$1;
 else
  fatal "$TOPDIR/$1 does not exist!";
 fi
}

function warn()
{
 echo "Warning: $*" 1>&2;
 echo "Warning: $*" >>$LOGFILE
}

function error()
{
 echo "Error: $*" 1>&2;
 echo "Error: $*" >>$LOGFILE
}

function fatal()
{
 echo "Fatal error: $*" 1>&2
 echo "Fatal error: $*" >>$LOGFILE;
 exit 1;
}

function log()
{
 echo "$*";
 echo "$*">>$LOGFILE;
}

function run()
{
 log "==> Executing \"$1\"...";
 out=$($*);
 log "===> Finished!";
 log "===> Output:";
 log "$out";
}

declare WIDTH=$(tput cols)

function init()
{
 log "=> Initiating system..."
}

function leave()
{
 log "=> Finishing up!"
 if [ -n "$1" ]
 then
  eval 'exit $1';
 else
  exit 0;
 fi
}


