<?php

namespace Optimax\RuleBundle\Service;

use Optimax\RuleBundle\Entity\Rule;
use Optimax\RuleBundle\Repository\RuleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RuleService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @param EntityManager $entityManager
     * @param ParameterBagInterface $params
     */
    public function __construct(EntityManager $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
        $this->params = $params;
    }

    /**
     * @param string $target
     * @param mixed $object
     * @param mixed $subject
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function applyRules(string $target, &$object, $subject, Request $request): void
    {
        if (!is_object($object)) {
            $type = gettype($object);
            throw new \InvalidArgumentException("Invalid object type, it is {$type}");
        }

        /** @var RuleRepository $ruleRepository */
        $ruleRepository = $this->entityManager->getRepository('rule');

        /** @var Rule $rule */
        foreach ($ruleRepository->getAvailableRules($target) as $rule) {
            $rule->setObject($object)
                ->setSubject($subject)
                ->setRequest($request);

            $rule->getAction($this->params)->execute($object);
        }
    }
}
