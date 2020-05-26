<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/invoicea5dot.php';

class Inva5dot extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}

?>
