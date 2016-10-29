<?php
namespace Admin\Controller;

use Think\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $this->display('admin_dashboard');
    }
}
