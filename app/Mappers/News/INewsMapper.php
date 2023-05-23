<?php

namespace App\Mappers\News;

use App\Entities\NewsEntity;

interface INewsMapper
{
    public function fromApi(mixed $data): NewsEntity;
}
