#!/bin/bash

if [ -x "$JJCMD_DIR_BIN/jjcmd.sh" ]; then

  JJCMD_PATH="$JJCMD_DIR_BIN/jjcmd.sh";

else

  JJCMD_PATH="$( command -v jjcmd.sh )";

fi;

jj() {

  local command='';
  local type="$( "$JJCMD_PATH" get-type "$@" )";

  jj_log_trace "command..: $JJCMD_PATH" "$@";
  jj_log_trace "type.....: $type";

  case "$type" in

    shell)

      while IFS= read -r path; do

        jj_log_trace $path;

        if [ -d "$path" ]; then

          pushd "$path" > /dev/null || return 1;

        elif [ -e "$path" ]; then

          vim "$path" < /dev/tty || return 1;

        else

          >&2 echo "path not found: $path";

          return 1;

        fi;

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
