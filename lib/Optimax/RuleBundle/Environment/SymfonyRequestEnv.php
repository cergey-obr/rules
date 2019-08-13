<?php

namespace Optimax\RuleBundle\Environment;

use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestEnv extends AbstractEnvironment
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->query = $request->query->all();
        $this->request = $request->request->all();
        $this->cookies = $request->cookies->all();
        $this->headers = $request->headers->all();
        $this->server = $request->server->all();
    }
}
