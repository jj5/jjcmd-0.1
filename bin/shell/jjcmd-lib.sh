#!/bin/bash

JJCMD_PATH="$( command -v jjcmd.sh )";

jj() {

  local command='';
  local type="$( "$JJCMD_PATH" get-type "$@" )";

  jj_log_trace "command..: $JJCMD_PATH" "$@";
  jj_log_trace "type.....: $type";

  case "$type" in

    shell)

      while IFS= read -r command; do

        jj_log_trace $command;

        $command < /dev/tty || return 1;

      done < <( "$JJCMD_PATH" "$@" );

      jj_log_trace "done.";

      ;;

    *)

      "$JJCMD_PATH" "$@";;

  esac;

}

jj_log_trace() {

  [ -e /home/jj5/desktop/trace.log ] || return 0;

  echo "jj_log_trace:" "$@" >> /home/jj5/desktop/trace.log;

}

jj_complete() {

  local IFS=$'\n';

  COMPREPLY=( $( "$JJCMD_PATH" complete "$@" ) );

}

complete -o filenames -o nospace -o bashdefault -F jj_complete jj
