<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addDate;

    /**
     * @ORM\Column(type="float")
     */
    private $raiting;

    /**
     * @ORM\OneToMany(targetEntity=Feedback::class, mappedBy="product_id", orphanRemoval=true)
     */
    private $feedbacks;

    public function __construct()
    {
        $this->feedbacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }

    public function getRaiting(): ?float
    {
        //return $this->raiting;

        $result = $this->feedbacks;
        $avg = 0;
        if (count($result) === 0) {
            return $avg;
        }
        else {
            foreach ($result as $item) {
                $avg += $item->getRaiting();
            }
            return $avg / count($result);
        }
    }

    public function setRaiting(float $raiting): self
    {
        $this->raiting = $raiting;

        return $this;
    }

    private $feedbacksAmount;

    public function getFeedbacksAmount(): int
    {
        return count($this->feedbacks);
    }

    public function getFeedbackAmount(): int
    {
        return count($this->feedbacks);
    }

    /**
     * @return Collection|Feedback[]
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }


    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks[] = $feedback;
            $feedback->setProductId($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedbacks->contains($feedback)) {
            $this->feedbacks->removeElement($feedback);
            // set the owning side to null (unless already changed)
            if ($feedback->getProductId() === $this) {
                $feedback->setProductId(null);
            }
        }

        return $this;
    }
}
