<?php
namespace Admin\Controller;

use Think\Controller;

class MaterialController extends Controller
{
    public function index()
    {
        $this->display("Admin_manageMaterial");
    }

    public function createMaterial()
    {
        $this->display("Admin_createMaterial");
    }

    public function syncMaterial()
    {

    }

    public function downloadMaterial()
    {

    }
}
