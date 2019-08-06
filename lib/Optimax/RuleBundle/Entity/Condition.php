<?php

namespace Optimax\RuleBundle\Entity;

use Symfony\Component\HttpFoundation\Request;
use Optimax\RuleBundle\Service\ConditionService;

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
     * @param Request $request
     *
     * @return bool
     */
    public function isValid($object, $subject, Request $request): bool
    {
        $conditionService = new ConditionService();
        $type = strtok($this->attribute, self::DELIMITER);
        $this->attribute = substr($this->attribute, strlen($type) + 1);

        switch ($type) {
            case 'request':
                $object = $request;
                break;

            case 'subject':
                $object = $subject;
                break;
        }

        return $conditionService->check($this->operator, $this->getObjectValue($object), $this->value);
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    private function getObjectValue($object)
    {
        foreach (explode(self::DELIMITER, $this->attribute) as $propertyName) {
            if ($object instanceof Request) {
                $object = $object->get($propertyName, '');
            } elseif (is_object($object) && property_exists($object, $propertyName)) {
                $object = $object->$propertyName;
            } elseif (is_array($object)) {
                $object = $object[$propertyName] ?? '';
            } else {
                return '';
            }
        }

        return $object;
    }
}
