<?php namespace Tobz\Autoform\Contracts;

interface InputFieldInterface
{

    public function __toString();

    public function setId($type);
    public function getId();

    public function setName($type);
    public function getName();

    public function setType($type);
    public function getType();

    public function setValue($value);
    public function getValue();

    /**
     * Is this a checkable field?
     *
     * @return boolean
     */
    public function isCheckable();
}
