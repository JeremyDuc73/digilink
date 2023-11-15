<?php

namespace App\Entity;

use App\Repository\RepostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepostRepository::class)]
class Repost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'reposts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $originalPost = null;

    #[ORM\ManyToOne(inversedBy: 'reposts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $repostedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOriginalPost(): ?Post
    {
        return $this->originalPost;
    }

    public function setOriginalPost(?Post $originalPost): static
    {
        $this->originalPost = $originalPost;

        return $this;
    }

    public function getRepostedBy(): ?Profile
    {
        return $this->repostedBy;
    }

    public function setRepostedBy(?Profile $repostedBy): static
    {
        $this->repostedBy = $repostedBy;

        return $this;
    }
}
