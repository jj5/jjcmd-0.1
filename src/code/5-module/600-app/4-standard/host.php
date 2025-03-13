<?php

define( 'APP_STATICMAGIC_DIR', '/etc/staticmagic' );

class jj_host extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Info;

  }

  protected function define_description() : string {

    return "Prints information about this host.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'INFO' );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-14 jj5 - fields...
  //

  protected $option_map = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_option( 'class', <<<'EOT'
The three letter class of the current host.

adm: administration server (mail, web, etc.)
cnf: configuration management server (e.g. salt-master)
crt: certificate authority
cus: customer system
dev: development system
dns: DNS server
lab: test system (laboratory)
log: logging and analytics server (e.g. Zabbix)
mbp: MacBook Pro
mdb: MariaDB or MySQL database server
mso: Mixed Signal Oscilloscope
net: network device
rtr: router
srv: server
ssl: certificate repository (Let's Encrypt)
tra: terraform client, bastion
vmw: VMWare virtual machine
web: web server
win: Windows system
wrk: workstation
EOT
    );

    $this->add_option( 'deployment', <<<'EOT'
The type of deployment of the current host.

test: a test system
prod: a production system
EOT
    );

    $this->add_option( 'domain', <<<'EOT'
?>
The parent domain name of the current host.
EOT
    );

    $this->add_option( 'environment', <<<'EOT'
?>
The environment of the current host.

amaz: in an AWD data center
home: on the LAN at home
mobi: a mobile system
vbox: in a VirtualBox VM
ware: in a VMWare Fusion VM
EOT
    );

    $this->add_option( 'fqdn', <<<'EOT'
?>
The fully qualified domain name of the current host.
EOT
    );

    $this->add_option( 'host', <<<'EOT'
?>
The hostname of the current host.
EOT
    );

    $this->add_option( 'host-prod', <<<'EOT'
?>
The hostname of the production host related to the current host.
EOT
    );

    $this->add_option( 'host-test', <<<'EOT'
?>
The hostname of the test host related to the current host.
EOT
    );

    $this->add_option( 'id', <<<'EOT'
?>
The ID of the current host, in the form:

 $sysid-$realm-$class-$typenum-$host-$deployment-$environment
EOT
    );

    $this->add_option( 'instance-type', <<<'EOT'
?>
The instance type. Relevant for AWS EC2 hosts. E.g.:

* t2.nano
* t2.micro
* t2.small
* t2.medium
EOT
    );

    $this->add_option( 'net', <<<'EOT'
?>
The network zone:

GREEN...: level 3 LAN
ORANGE..: level 2 LAN
RED.....: level 1 LAN
BLUE....: DMZ
PURPLE..: public Internet
EOT
    );

    $this->add_option( 'netenv', <<<'EOT'
?>
The network environment of the current host.

test: a test network
prod: a production network
EOT
    );

    $this->add_option( 'provider', <<<'EOT'
?>
The provider of the current host.

amaz: AWS
home: bare metal
rack: Rackspace
vbox: VirtualBox VM
ware: VMWare Fusion VM
EOT
    );

    $this->add_option( 'realm', <<<'EOT'
The two letter realm of the current host.

bk: Blackbrick
jj: jj5.net
pc: ProgClub
sm: staticmagic.net
EOT
    );

    $this->add_option( 'sysid', <<<'EOT'
The system of the current host, in the form:

 $realm-$class-$typenum
EOT
    );

    $this->add_option( 'typenum', <<<'EOT'
The single digit type number of the current host.
EOT
    );

  }

  protected function add_option( string $name, string $description ) {

    $this->option_map[ $name ] = [ 'name' => $name, 'description' => $description ];

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    if ( ! is_dir( APP_STATICMAGIC_DIR ) ) {

      return;

    }

    foreach ( scandir( APP_STATICMAGIC_DIR ) as $file ) {

      if ( $file[ 0 ] !== '.' ) {

        if ( strpos( $file, $arg2 ) === 0 ) {

          echo "$file\n";

        }
      }
    }
  }

  public function run() {

    $item_list = $this->get_arg( 'INFO' );

    if ( count( $item_list ) === 1 ) {

      $item = $item_list[ 0 ];

      $value = $this->get_item( $item );

      echo "$value\n";

    }
    else {

      $max_len = 0;

      foreach ( $item_list as $item ) {

        $max_len = max( $max_len, strlen( $item ) );

      }

      foreach ( $item_list as $item ) {

        $this->print_item( $item, $max_len );

      }
    }
  }

  public function print_help( $args ) {

    if ( count( $args ) < 2 ) {

      parent::print_help( $args );

    }
    else {

      $item = $args[ 1 ] ?? null;

      $description = $this->option_map[ $item ][ 'description' ] ?? '';

      echo "$description\n";

    }
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function get_item( string $item ) {

    $path = APP_STATICMAGIC_DIR . "/$item";

    if ( ! is_file( $path ) ) {

      return '';

    }

    return trim( file_get_contents( $path ) );

  }

  protected function print_item( string $item, int $max_len ) {

    $value = $this->get_item( $item );

    echo str_pad( $item, $max_len + 2, '.' ) . ': ' . $value . "\n";

  }
}
