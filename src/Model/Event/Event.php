<?php

declare(strict_types=1);

namespace App\Model\Event;

use Sulu\Component\Persistence\Model\AuditableInterface;
use Sulu\Component\Persistence\Model\AuditableTrait;

class Event implements AuditableInterface, EventInterface
{
    use AuditableTrait;

    const RESOURCE_KEY = 'events';
    const FORM_KEY = 'event_details';
    const LIST_KEY = 'events';

    /**
     * @var int
     */
    private $no;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var \DateTime|null
     */
    private $date;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(?string $locale = null): string
    {
        return $this->title;
    }

    public function setTitle(string $title): EventInterface
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): EventInterface
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): EventInterface
    {
        $this->date = $date;
        return $this;
    }

}
