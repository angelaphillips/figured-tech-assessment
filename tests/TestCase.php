<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // expecting 42 for 10 units
    //  //expecting 54.6 for 13 units
    //  //expecting 89.6 for 20 units
    // expecting  211,6 for all (43)
    // 30 -139.6
    // 23 - 104.6
    // To-do comments need to be better
}
