<?php

declare(strict_types=1);

namespace App\Model\Event;

interface EventInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function setTitle(string $title): self;

    public function getDescription(): string;

    public function setDescription(string $description): self;

    public function getDate(): ?\DateTime;

    public function setDate(?\DateTime $date): self;
}
