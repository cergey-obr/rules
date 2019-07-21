<?php

namespace App\Controller;

use App\Service\RuleService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/test", methods={"GET"}, name="test")
     *
     * @param Request $request
     * @param RuleService $service
     *
     * @return JsonResponse
     */
    public function test(Request $request, RuleService $service): JsonResponse
    {
        $object = (object)['price' => 100];
        $service->applyRules('product', $object);
        $t = 1;

        return new JsonResponse(['test' => 1]);
    }
}
