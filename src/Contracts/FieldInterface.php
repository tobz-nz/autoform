<?php namespace Tobz\Autoform\Contracts;

interface FieldInterface
{

    public function __toString();
    public function renderField();

    /**
     * Set
     * @param string $value
     *
     * @return Tobz\Autoform\FieldInterface
     */
    public function setId($value);
    public function getId();


    /**
     * Set
     * @param string $value
     *
     * @return Tobz\Autoform\FieldInterface
     */
    public function setName($type);
    public function getName();


    /**
     * Set
     * @param string $value
     *
     * @return Tobz\Autoform\FieldInterface
     */
    public function setValue($value);
    public function getValue();


    /**
     * Set
     * @param string $value
     *
     * @return Tobz\Autoform\FieldInterface
     */
    public function setLabel($value);
    public function getLabel();
    public function renderLabel();

    public function attributeString();

    /**
     * Set
     * @param string $before
     * @param string $after
     *
     * @return Tobz\Autoform\FieldInterface
     */
    public function wrap($before, $after = null);

    /**
     * Set
     * @param string $value
     *
     * @return Tobz\Autoform\FieldInterface
     */
    public function setBefore($value);
    public function getBefore();

    /**
     * Set
     * @param string $value
     *
     * @return Tobz\Autoform\FieldInterface
     */
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
