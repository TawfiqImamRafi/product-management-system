<?php

namespace App\Repositories\AuthApi;

interface AuthRepositoryInterface {

    public function login($request);

    public function register($request);

    public function authUser();

    public function logout();

}
