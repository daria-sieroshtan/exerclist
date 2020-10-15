<?php

namespace App\Entity;

interface OwnableEntityInterface
{
    /**
     * @return bool
     */
    public function getIsPrivate();

    /**
     * @return \App\Entity\User
     */
    public function getUser();
}
