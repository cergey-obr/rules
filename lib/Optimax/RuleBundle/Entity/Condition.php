<?php

namespace Optimax\RuleBundle\Entity;

use Optimax\RuleBundle\Service\ConditionService;
use Optimax\RuleBundle\Environment\AbstractEnvironment;

class Condition extends AbstractEntity
{
    const DELIMITER = '.';

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string
     */
    private $value;

    /**
     * @param mixed $object
     * @param mixed $subject
     * @param AbstractEnvironment $environment
     *
     * @return bool
     */
    public function isValid($object, $subject, AbstractEnvironment $environment): bool
    {
        $conditionService = new ConditionService();
        $paths = explode(self::DELIMITER, $this->attribute);
        $type = array_shift($paths);

        switch ($type) {
            case 'env':
                $object = $environment;
                break;

            case 'subject':
                $object = $subject;
                break;
        }

        return $conditionService->check($this->operator, $this->getObjectValue($paths, $object), $this->value);
    }

    /**
     * @param array $paths
     * @param object|array $object
     *
     * @return mixed
     */
    public function getObjectValue(array $paths, $object)
    {
        foreach ($paths as $propertyName) {
            array_shift($paths);

            if (is_object($object)) {
                $object = (array)$object;
            }

            $propertyValue = $object[$propertyName] ?? '';
            return $this->getObjectValue($paths, $propertyValue);
        }

        return $object;
    }
}
