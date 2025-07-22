<?php

namespace App\Services\APIService\Muhuri;


use Illuminate\Http\Client\Response;

abstract class MuhuriBaseService
{
    abstract public function sendRequest(): Response;

}
