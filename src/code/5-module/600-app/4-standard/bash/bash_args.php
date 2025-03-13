<?php

class jj_bash_args extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "How to read arguments in BASH.";

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function print() {
?>
# read arg 1 or use empty string '' if not provided:
#
local not_null="${1:-}";

# read arg 1 or use 'missing' if not provided:
#
local not_null="${1:-missing}";

# non-destructively:
#
for var in "$@"; do
  echo "$var";
done;

# destructively:
#
while [[ $# > 0 ]]; do
  local var="$1";
  shift;
  echo "$var";
done;
<?php
  }
}
