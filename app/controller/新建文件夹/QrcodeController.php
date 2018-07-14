<?php
namespace App\controller;

class QrcodeController extends ApiController
{
    private $QRcode = null;
    public function __construct()
    {
        include_once(VENDOR_PATH.'phpqrcode/lib/full/qrlib.php');
    }

    public function  generate($text)
    {
        if(empty($text)) $this->error('缺少二维码信息');
        \QRcode::png($text, false);
    }
}