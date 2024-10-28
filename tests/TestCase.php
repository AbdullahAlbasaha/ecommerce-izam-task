<?php

namespace Tests;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
}
