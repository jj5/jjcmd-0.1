<?php

abstract class AppCommand extends AppTask {

  public function get_type() : string { return 'command'; }

}
