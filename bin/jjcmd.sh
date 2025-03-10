#!/bin/bash

main() {

  set -euo pipefail;

  local script_dir=$( dirname "$( readlink -f "$0" )" );

  "$script_dir/libexec/jjcmd.php" "$@";

}

main "$@";
