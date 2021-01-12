<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public $dataNotUpdate = [];
    public $dataUpdated = [];

    public function __construct($dataNotUpdate, $dataUpdated)
    {
        $this->dataNotUpdate = $dataNotUpdate;
        $this->dataUpdated = $dataUpdated;
    }

    public function checkUpdateCustomer()
    {
        $b = $this->dataUpdated;
        $a = $this->dataNotUpdate;
        // Check Name
        if($b['name'] != $a['name'])
        {
            $this->createHistoryCustomer(" Họ tên: ".$b['name'], $b['id']);
        }
        // Check Cmnd
        if($b['cmnd'] != $a['cmnd'])
        {
            $this->createHistoryCustomer(" Cmnd: ".$b['cmnd'], $b['id']);
        }
        // Check Phone
        if($b['phone'] != $a['phone'])
        {
            $this->createHistoryCustomer(" Số điện thoại: ".$b['phone'], $b['id']);
        }
        // Check Household
        if($b['household'] != $a['household'])
        {
            $this->createHistoryCustomer(" Hộ khẩu: ".$b['household'], $b['id']);
        }
        // Check Birthday
        if($b['birthday'] != $a['birthday'])
        {
            $this->createHistoryCustomer(" Ngày sinh: ".$b['birthday'], $b['id']);
        }
        // Check Address
        if($b['address'] != $a['address'])
        {
            $this->createHistoryCustomer(' Địa chỉ: '.$b['address'], $b['id']);
        }
    }

    public function createHistoryCustomer($target, $id)
    {
        History::create([
            'title' => Auth::user()->name." đã thay đổi ".$target ,
            'customer_id' => $id
        ]);
    }
}
