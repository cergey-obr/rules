<?php

namespace Optimax\RuleBundle\Service;

use Optimax\RuleBundle\Entity\Rule;
use Optimax\RuleBundle\Exceptions\CheckRuleException;
use Optimax\RuleBundle\Repository\RuleRepository;
use Optimax\RuleBundle\Environment\SymfonyRequestEnv;
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
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function applyRules(string $target, $object, $subject, Request $request): void
    {
        if (!is_object($object)) {
            $type = gettype($object);
            throw new \InvalidArgumentException("Invalid object type, it is {$type}");
        }

        /** @var RuleRepository $ruleRepository */
        $ruleRepository = $this->entityManager->getRepository('rule');
        $actionsNamespace = $this->params->get('optimax_rule.namespace');
        $environment = new SymfonyRequestEnv($request);

        /** @var Rule $rule */
        foreach ($ruleRepository->getAvailableRules($target) as $rule) {
            try {
                $rule->check($object, $subject, $environment);

                $action = $rule->getAction($object, $subject, $environment);
                $action->load($actionsNamespace)->execute($object);

                if ($action->isStopProcessing()) {
                    break;
                }
            } catch (CheckRuleException $e) {
                continue;
            }
        }
    }
}
