<?php namespace Tobz\Autoform\Contracts;

interface CheckableFieldInterface extends FieldInterface
{

    /**
     * Is this field currently checked?
     *
     * @return boolean
     */
    public function isChecked();

    /**
     * Toggle the checked status
     *
     * @param  boolean $check
     */
    public function check($check);
}
