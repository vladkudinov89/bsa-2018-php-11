<?php

namespace App\Request\Contracts;


interface AddLotFormRequest
{
    public function authorize() : bool;

    public function rules() : array;

}