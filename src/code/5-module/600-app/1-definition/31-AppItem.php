<?php

class AppItem {

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  public $name;
  public $path;
  public $is_svn;
  public $is_git;
  public $tag_list = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct( $name, $path ) {

    $this->name = $name;
    $this->path = $path;

    $this->is_svn = is_dir( "$path/.svn" );
    $this->is_git = is_dir( "$path/.git" );

    if ( $this->is_svn ) { $this->tag_list[] = 'svn'; }
    if ( $this->is_git ) { $this->tag_list[] = 'git'; }

  }
}
