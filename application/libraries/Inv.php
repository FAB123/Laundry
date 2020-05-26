<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/invoice.php';

class Inv extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

?>
