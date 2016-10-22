<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Chronicle
{
    private $id;

    private $name;
    private $createdAt;

    // Associations
    private $game;
    private $creator;
    private $characters;
    private $memberships;


    // Constructor
    public function __construct(User $creator=null) {
        $this->creator = $creator;

        $this->characters = new ArrayCollection();
        $this->memberships = new ArrayCollection();
    }


    /**
     * Set createdAt at the current time.
     *
     * (Lifecycle callback)
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    // Getter and setters


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Chronicle
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Chronicle
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add character
     *
     * @param \AppBundle\Entity\Character $character
     *
     * @return Chronicle
     */
    public function addCharacter(\AppBundle\Entity\Character $character)
    {
        $this->characters[] = $character;

        return $this;
    }

    /**
     * Remove character
     *
     * @param \AppBundle\Entity\Character $character
     */
    public function removeCharacter(\AppBundle\Entity\Character $character)
    {
        $this->characters->removeElement($character);
    }

    /**
     * Get characters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Set creator
     *
     * @param \AppBundle\Entity\User $creator
     *
     * @return Chronicle
     */
    public function setCreator(\AppBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return Chronicle
     */
    public function setGame(\AppBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Add membership
     *
     * @param \AppBundle\Entity\Membership $membership
     *
     * @return Chronicle
     */
    public function addMembership(\AppBundle\Entity\Membership $membership)
    {
        $this->memberships[] = $membership;

        return $this;
    }

    /**
     * Remove membership
     *
     * @param \AppBundle\Entity\Membership $membership
     */
    public function removeMembership(\AppBundle\Entity\Membership $membership)
    {
        $this->memberships->removeElement($membership);
    }

    /**
     * Get memberships
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMemberships()
    {
        return $this->memberships;
    }
}
