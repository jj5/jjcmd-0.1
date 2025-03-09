#!/bin/bash

main() {

  set -euo pipefail;

  case "$1" in

    get-type)

      case "$2" in

        edit)

          echo shell;;

        *)

          echo script;;

      esac;;

    edit)

      echo "echo 1";
      echo "echo 2";;

    *)

      echo jjcmd.php "$@";;

  esac;

}

main "$@";
