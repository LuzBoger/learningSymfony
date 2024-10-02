<?php

namespace App\Entity;

use App\Repository\SubscriptionHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionHistoryRepository::class)]
class SubscriptionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $startDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptionHistories')]
    private ?user $currentSubscription = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptionHistories')]
    private ?Subscription $subscription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCurrentSubscription(): ?user
    {
        return $this->currentSubscription;
    }

    public function setCurrentSubscription(?user $currentSubscription): static
    {
        $this->currentSubscription = $currentSubscription;

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?Subscription $subscription): static
    {
        $this->subscription = $subscription;

        return $this;
    }
}
