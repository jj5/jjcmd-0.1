<?php

class jj_bash_case extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "How to use case statements in BASH.";

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
case $month in
  February)
    echo "There are 28/29 days in $month.";;
  April | June | September | November)
    echo "There are 30 days in $month.";;
  January | March | May | July | August | October | December)
    echo "There are 31 days in $month.";;
  *)
    echo "Unknown month.";;
esac;

case $var in
  [[:lower:]]) echo "You entered a lowercase character.";;
  [[:upper:]]) echo "You entered an uppercase character.";;
  [0-9]) echo "You entered a digit.";;
  ?) echo "You entered a single character.";;
  *) echo "You entered multiple characters.";;
esac;
<?php
  }
}
