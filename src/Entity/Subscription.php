<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription
{
    private static $planDataNames = ['free', 'pro', 'enterprise'];
    private static $planDataPrices = ['free' => 0, 'pro' => 15, 'enterprise' => 29];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chosenPlan;

    /**
     * @ORM\Column(type="datetime")
     */
    private $valid_to;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $payment_status;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $free_plan_used;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChosenPlan(): ?string
    {
        return $this->chosenPlan;
    }

    public function setChosenPlan(string $chosenPlan): self
    {
        $this->chosenPlan = $chosenPlan;

        return $this;
    }

    public function getValidTo(): ?DateTimeInterface
    {
        return $this->valid_to;
    }

    public function setValidTo(DateTimeInterface $valid_to): self
    {
        $this->valid_to = $valid_to;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(?string $payment_status): self
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    public function getFreePlanUsed(): ?bool
    {
        return $this->free_plan_used;
    }

    public function setFreePlanUsed(?bool $free_plan_used): self
    {
        $this->free_plan_used = $free_plan_used;

        return $this;
    }

    public static function getPlanDataNameByIndex(int $index)
    {
        return self::$planDataNames[$index];
    }

    public static function getPlanDataPriceByName(string $name)
    {
        return self::$planDataPrices[$name];
    }

    public static function getPlanDataNames(){
        return self::$planDataNames;
    }

    public static function getPlanDataPrices(){
        return self::$planDataPrices;
    }
}
