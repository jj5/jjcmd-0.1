#!/bin/bash

jj() {

  local item="$1";
  local command='';

  case "$( jjcmd.sh get-type "$item" )" in

    shell)

      jjcmd.sh "$@" | while IFS= read -r command; do

        echo $command;

        $command || return 1;

      done;;

    *)

      jjcmd.sh "$@";;

  esac;

}
