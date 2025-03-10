#!/bin/bash

jj() {

  local command='';

  case "$( jjcmd.sh get-type "${1:-}" )" in

    shell)

      jjcmd.sh "$@" | while IFS= read -r command; do

        echo $command;

        $command || return 1;

      done;;

    *)

      jjcmd.sh "$@";;

  esac;

}
