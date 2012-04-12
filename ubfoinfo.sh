#!/bin/bash

#set some env vars
TOPDIR=$(dirname $0)
LOGFILE=$TOPDIR/log.txt
GLOBARG=$@
MAINSCRIPT=$0
OPERATION='error "What?!!"'
COMMON_FIX=false

#i separated some helper funcs to a separate file,
# the include func is used from now on
source $TOPDIR/functions.sh

#initiate subsystems
init;

include argparser.sh;

args::parse;

echo "$OPERATION"

leave;

