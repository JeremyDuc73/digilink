<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'blackListed')]
    private Collection $blackList;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'blackList')]
    private Collection $blackListed;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $posts;

    #[ORM\OneToOne(mappedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    public function __construct()
    {
        $this->blackList = new ArrayCollection();
        $this->blackListed = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getBlackList(): Collection
    {
        return $this->blackList;
    }

    public function addBlackList(self $blackList): static
    {
        if (!$this->blackList->contains($blackList)) {
            $this->blackList->add($blackList);
        }

        return $this;
    }

    public function removeBlackList(self $blackList): static
    {
        $this->blackList->removeElement($blackList);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getBlackListed(): Collection
    {
        return $this->blackListed;
    }

    public function addBlackListed(self $blackListed): static
    {
        if (!$this->blackListed->contains($blackListed)) {
            $this->blackListed->add($blackListed);
            $blackListed->addBlackList($this);
        }

        return $this;
    }

    public function removeBlackListed(self $blackListed): static
    {
        if ($this->blackListed->removeElement($blackListed)) {
            $blackListed->removeBlackList($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(?User $ofUser): static
    {
        // unset the owning side of the relation if necessary
        if ($ofUser === null && $this->ofUser !== null) {
            $this->ofUser->setProfile(null);
        }

        // set the owning side of the relation if necessary
        if ($ofUser !== null && $ofUser->getProfile() !== $this) {
            $ofUser->setProfile($this);
        }

        $this->ofUser = $ofUser;

        return $this;
    }
}
