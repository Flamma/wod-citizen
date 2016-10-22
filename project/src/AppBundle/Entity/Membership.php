<?php
namespace AppBundle\Entity;

use \AppBundle\Entity\User;
use \AppBundle\Entity\Chronicle;

abstract class Membership
{
    // Associations
    private $chronicle;
    private $user;

    /**
     * @var integer
     */
    private $id;
    
    public function __construct(User $user=null, Chronicle $chronicle=null) 
    {
        $this->setUser($user);
        $this->setChronicle($chronicle);
    }


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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Membership
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set chronicle
     *
     * @param \AppBundle\Entity\Chronicle $chronicle
     *
     * @return Membership
     */
    public function setChronicle(Chronicle $chronicle = null)
    {
        $this->chronicle = $chronicle;

        return $this;
    }

    /**
     * Get chronicle
     *
     * @return \AppBundle\Entity\Chronicle
     */
    public function getChronicle()
    {
        return $this->chronicle;
    }
}
