<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class f_pdf {
    function __construct() {
        include_once APPPATH . '/third_party/fpdf182/fpdf.php';
    }
}

?>