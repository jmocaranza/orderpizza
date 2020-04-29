<?php

namespace App\Entity;
use App\Entity\Pizza;
use App\Entity\Topping;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_entered;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pizza", mappedBy="orders",cascade={"persist"})
     */
    private $pizzas;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->pizzas = new ArrayCollection();
    }

    /**
     * Get Order id
     *
     * @return string order id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get Order date entered
     *
     * @return DateTime date entered
     */
    public function getDateEntered(): ?\DateTimeInterface
    {
        return $this->date_entered;
    }

    /**
     * Set Order date entered
     *
     * @param DateTimeInterface $date_entered  Date entered
     *
     * @return this
     */
    public function setDateEntered(\DateTimeInterface $date_entered): self
    {
        $this->date_entered = $date_entered;

        return $this;
    }

    /**
     * Get Order status
     *
     * @return string the order status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set Order status
     *
     * @param string $status  Order status
     *
     * @return this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Pizza[]
     */
    public function getPizzas(): Collection
    {
        return $this->pizzas;
    }

    /**
     * Add object pizza to the relationships
     *
     * @param Pizza $pizzas Pizza object
     *
     * @return this
     */
    public function addPizza(Pizza $pizza): self
    {
        if (!$this->pizzas->contains($pizza)) {
            $this->pizzas[] = $pizza;
            $pizza->setOrders($this);
        }

        return $this;
    }

    /**
     * Remove object pizza from the relationships
     *
     * @param Pizza $pizzas Pizza object
     *
     * @return this
     */
    public function removePizza(Pizza $pizza): self
    {
        if ($this->pizzas->contains($pizza)) {
            $this->pizzas->removeElement($pizza);
            // set the owning side to null (unless already changed)
            if ($pizza->getOrders() === $this) {
                $pizza->setOrders(null);
            }
        }

        return $this;
    }

    /**
     * Add multiple pizzas objects
     *
     * @param array $pizzas array of pizzas
     *
     * @return void
     */
    public function addPizzas( array $pizzas)    {

        foreach( $pizzas as $p ) {
            $pizza = new Pizza();
            $pizza->setSize( $p['size'] );

            foreach( $p['toppings'] as $t ) {
                $topping = new Topping();
                $topping->setName( $t );
                $pizza->addTopping($topping);
            }

            $this->addPizza( $pizza );
        }
    }
}
