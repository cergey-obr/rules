<?php

namespace Optimax\RuleBundle\Environment;

abstract class AbstractEnvironment
{
    /**
     * @var array
     */
    public $query = [];

    /**
     * @var array
     */
    public $request = [];

    /**
     * @var array
     */
    public $cookies = [];

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @var array
     */
    public $server = [];
}
