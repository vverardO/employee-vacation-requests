<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const INVALID_NAME_SIZE = 129;

    const INVALID_GENERAL_RECORD_SIZE = 12;

    const INVALID_REGISTRATION_PHYSICAL_PERSON_SIZE = 15;
}
