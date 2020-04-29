<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ToppingRepository")
 */
class Topping
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pizza", inversedBy="toppings")
     */
    private $pizza;

    /**
     * Get Topping id
     *
     * @return string Topping id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get Topping name
     *
     * @return string Topping name
     */    
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set Topping name
     *
     * @param string $name  Topping name
     *
     * @return this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Pizza object
     *
     * @return Pizza Pizza object
     */
    public function getPizza(): ?Pizza
    {
        return $this->pizza;
    }

    /**
     * Set Pizza  relationship
     *
     * @param Pizza $pizza  Pizza object
     *
     * @return this
     */
    public function setPizza(?Pizza $pizza): self
    {
        $this->pizza = $pizza;

        return $this;
    }
}
