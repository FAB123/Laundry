<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/invoicea4dot.php';

class Inva4dot extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

?>
