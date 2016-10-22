<?php

namespace AppBundle\Entity;

/**
 * Friendship
 */
class Friendship
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $accepted;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user1;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user2;


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
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Friendship
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set user1
     *
     * @param \AppBundle\Entity\User $user1
     *
     * @return Friendship
     */
    public function setUser1(\AppBundle\Entity\User $user1 = null)
    {
        $this->user1 = $user1;

        return $this;
    }

    /**
     * Get user1
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * Set user2
     *
     * @param \AppBundle\Entity\User $user2
     *
     * @return Friendship
     */
    public function setUser2(\AppBundle\Entity\User $user2 = null)
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser2()
    {
        return $this->user2;
    }
}

