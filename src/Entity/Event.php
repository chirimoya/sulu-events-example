<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Sulu\Component\Persistence\Model\AuditableInterface;
use Sulu\Component\Persistence\Model\AuditableTrait;

/**
 * @ORM\Table(name="app_events")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Event implements AuditableInterface
{
    use AuditableTrait;

    const RESOURCE_KEY = 'events';
    const FORM_KEY = 'event_details';
    const LIST_KEY = 'events';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("id")
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("title")
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("description")
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("date")
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
