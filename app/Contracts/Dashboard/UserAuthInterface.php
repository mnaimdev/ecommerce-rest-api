<?php

namespace App\Contracts\Dashboard;

interface UserAuthInterface
{
    public function userRegisterProcess($request);
    public function userLoginProcess($request);
    public function userLogoutProcess($request);
    public function userInfo($request);
    public function userProfileUpdate($request);
}
