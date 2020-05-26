<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/invoicea5.php';

class Inva5 extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

?>
