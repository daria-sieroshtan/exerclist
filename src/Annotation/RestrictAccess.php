<?php

namespace App\Annotation;

/**
 * @Annotation
 */
class RestrictAccess
{
    public $write = false;

    /**
     * @return bool
     */
    public function getWrite(): bool
    {
        return $this->write;
    }

    /**
     * @param bool $write
     */
    public function setWrite(bool $write): void
    {
        $this->write = $write;
    }
}
