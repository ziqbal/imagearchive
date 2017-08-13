#!/bin/bash

#
# kill -9 -SPID
#

if [ ! -f /Applications/XAMPP/bin/php ]; then
    INTERPRETER="/usr/bin/php"
else
    INTERPRETER="/Applications/XAMPP/bin/php"
fi

STARTDIR=$(pwd)
SCRIPTDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

TIMESTAMP=$(date +%s)
HOSTNAME=$(hostname)
PID=$$

FILENAME=$(basename "${BASH_SOURCE[0]}")
EXTENSION="${FILENAME##*.}"
FNAME=component-"${FILENAME%.*}"

cd $SCRIPTDIR

if [ -d $FNAME ]; then
    FNAME=$FNAME/boot
fi

$INTERPRETER $FNAME.php $STARTDIR "$@" $HOSTNAME $TIMESTAMP $PID
