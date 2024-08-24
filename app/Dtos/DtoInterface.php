<?php

namespace App\DTOs;
use Illuminate\Contracts\Validation\Validator;
interface DtoInterface
{
    public function rules():array;
    public function messages():array;
    public function validator():Validator;
    public function validate();
}
