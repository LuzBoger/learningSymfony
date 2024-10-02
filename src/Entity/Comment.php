<?php

namespace App\Entity;

use App\Enum\CommentStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(enumType: CommentStatusEnum::class)]
    private ?CommentStatusEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $customer = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parentComment')]
    private ?self $comment = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'comment')]
    private Collection $parentComment;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?media $media = null;

    public function __construct()
    {
        $this->parentComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?CommentStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CommentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getComment(): ?self
    {
        return $this->comment;
    }

    public function setComment(?self $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentComment(): Collection
    {
        return $this->parentComment;
    }

    public function addParentComment(self $parentComment): static
    {
        if (!$this->parentComment->contains($parentComment)) {
            $this->parentComment->add($parentComment);
            $parentComment->setComment($this);
        }

        return $this;
    }

    public function removeParentComment(self $parentComment): static
    {
        if ($this->parentComment->removeElement($parentComment)) {
            // set the owning side to null (unless already changed)
            if ($parentComment->getComment() === $this) {
                $parentComment->setComment(null);
            }
        }

        return $this;
    }

    public function getMedia(): ?media
    {
        return $this->media;
    }

    public function setMedia(?media $media): static
    {
        $this->media = $media;

        return $this;
    }

}
