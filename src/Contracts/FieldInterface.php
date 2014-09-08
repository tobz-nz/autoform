<?php namespace Tobz\Autoform\Contracts;

interface FieldInterface
{

    public function __toString();
    public function renderField();

    public function setId($type);
    public function getId();

    public function setName($type);
    public function getName();

    public function setValue($value);
    public function getValue();

    public function setLabel($value);
    public function getLabel();
    public function renderLabel();

    public function attributeString();

    public function wrap($before, $after = null);
    public function setBefore($value);
    public function getBefore();
    public function setAfter($value);
    public function getAfter();

    /**
     * Is this a checkable field?
     *
     * @return boolean
     */
    public function isCheckable();
    public function isSelectable();
}
