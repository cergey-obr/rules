<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Optimax\RuleBundle\Service\RuleService;

class IndexController extends AbstractController
{
    /**
     * @Route("/test", methods={"GET"}, name="test")
     *
     * @param Request $request
     * @param RuleService $service
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function test(Request $request, RuleService $service): JsonResponse
    {
        $object = (object)[
            'price' => 1000,
            'name' => 'glasses'
        ];
        $service->applyRules('product', $object, [], $request);
        $t = 1;

        return new JsonResponse(['test' => 1]);
    }
}
