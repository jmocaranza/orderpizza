<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PizzaRepository")
 */
class Pizza
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="pizzas")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Topping", mappedBy="pizza",cascade={"persist"})
     */
    private $toppings;
    
    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->toppings = new ArrayCollection();
    }

    /**
     * Get Pizza id
     *
     * @return string pizza id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get Pizza size
     *
     * @return string Pizza size
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * Set Pizza size
     *
     * @param string $size  Pizza size
     *
     * @return this
     */
    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }


    /**
     * Get Order object
     *
     * @return Order Order object
     */
    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    /**
     * Set Order  relationship
     *
     * @param Order $orders  Order object
     *
     * @return this
     */
    public function setOrders(?Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * @return Collection|Topping[]
     */
    public function getToppings(): Collection
    {
        return $this->toppings;
    }

    /**
     * Add object topping to the relationships
     *
     * @param Topping $topping Topping object
     *
     * @return this
     */
    public function addTopping(Topping $topping): self
    {
        if (!$this->toppings->contains($topping)) {
            $this->toppings[] = $topping;
            $topping->setPizza($this);
        }

        return $this;
    }

    /**
     * Remove object Topping from the relationships
     *
     * @param Topping $topping Topping object
     *
     * @return this
     */
    public function removeTopping(Topping $topping): self
    {
        if ($this->toppings->contains($topping)) {
            $this->toppings->removeElement($topping);
            // set the owning side to null (unless already changed)
            if ($topping->getPizza() === $this) {
                $topping->setPizza(null);
            }
        }

        return $this;
    }
}
