<?php

namespace App\Entity;

use App\Repository\PostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostLikeRepository::class)]
#[ORM\Table(name: '`PostLikes`')]
class PostLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $isLikedBy = null;

    #[ORM\ManyToOne(inversedBy: 'postLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsLikedBy(): ?Profile
    {
        return $this->isLikedBy;
    }

    public function setIsLikedBy(?Profile $isLikedBy): static
    {
        $this->isLikedBy = $isLikedBy;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }
}
