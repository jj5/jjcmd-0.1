#!/bin/bash

jj() {

  local command='';
  local type="$( jjcmd.sh get-type "$@" )";

  echo "command..: jjcmd.sh" "$@" >&2;
  echo "type.....: $type" >&2;

  case "$type" in

    shell)

      while IFS= read -r command; do

        echo $command >&2;

        $command;

      done < <( jjcmd.sh "$@" );

      echo "done." >&2;

      ;;

    *)

      jjcmd.sh "$@";;

  esac;

}

jj_complete() {

  local IFS=$'\n';

  COMPREPLY=( $( jjcmd.sh complete "$@" ) );

}

complete -o filenames -o nospace -o bashdefault -F jj_complete jj
