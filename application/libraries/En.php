<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/function.php';

class En extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

?>
