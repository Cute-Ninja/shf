<?php

namespace App\Domain\Entity;

interface BaseEntityInterface
{
    public function isNew(): bool;

    public function getCreatedDate(): \DateTime;

    public function setCreatedDate(\DateTime $createdDate): void;

    public function getUpdatedDate(): \DateTime;

    public function setUpdatedDate(\DateTime $updatedDate): void;
}
