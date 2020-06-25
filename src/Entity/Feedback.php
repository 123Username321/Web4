<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeedbackRepository::class)
 * @ORM\Table(name="feedbacks")
 */
class Feedback
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      notInRangeMessage = "Значение должны быть от {{ min }} до {{ max }}",
     * )
     */
    private $raiting;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addDate;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="feedbacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="feedbacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        //return $this->userId;
        return $this->user_id;
    }

    public function setUserId(?User $userId): self
    {
        //$this->userId = $userId;

        //return $this;
        $this->user_id = $userId;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRaiting(): ?float
    {
        return $this->raiting;
    }

    public function setRaiting(float $raiting): self
    {
        $this->raiting = $raiting;

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

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }
}
