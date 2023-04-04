<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(name="feed")
 * @ORM\Entity
 */
class Feed
{
    /**
     * @var int
     *
     * @ORM\Column(name="idfeed", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idfeed;

    /**
     *
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * 
     *
     * @ORM\Column(name="feed", type="text", nullable=false)
     */
    private $feed;

    /**
     *
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    public function getIdfeed(): ?int
    {
        return $this->idfeed;
    }

    public function getFeed(): ?string
    {
        return $this->feed;
    }

    public function setFeed(string $feed): self
    {
        $this->feed = $feed;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?string
    {
        return date_format($this->date,"d.m.y");
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }
}
