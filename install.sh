#!/bin/bash

OS=$( lsb_release -si | tr [A-Z] [a-z] )
CODENAME=$( lsb_release -sc )
if [[ "$OS" != "debian" ]]; then
  echo "OS not supported, please do manual install"
  exit 1
fi

INSTALL=$(wget -qO - "https://github.com/anamunlam/ahkacp/raw/master/debian/${CODENAME}.sh" --no-check-certificate)
if [ "$?" -eq '0' ]; then
  bash -c "${INSTALL}"
fi
exit
