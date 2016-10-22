<?php

namespace AppBundle\Entity;

class Character
{
    private $name;
    
    // Associations
    private $user;

    /**
     * @var integer
     */
    private $id;
    
    public function __construct($name='Panete', \AppBundle\Entity\User $user=null) {
        $this->setName($name);
        $this->setUser($user);
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
     * Set name
     *
     * @param string $name
     *
     * @return Character
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Character
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        if($user != NULL) {
            if($this->user != $user) {
                $this->user = $user;
                
                $user->addCharacter($this);
            }
        }

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
}
