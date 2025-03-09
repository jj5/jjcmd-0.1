#!/usr/bin/env php
<?php

require_once __DIR__ . '/../../src/code/1-bootstrap/9-keystone.php';

//(new MudDbadmin)->create( $argv );

app()->run( $argv );
