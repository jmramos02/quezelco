<?php

class MyAccountController extends BaseController {

    public function index()
    {
        return View::make('/admin.my-account');
    }

}