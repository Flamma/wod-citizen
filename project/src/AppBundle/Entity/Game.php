<?php

namespace AppBundle\Entity;

class Game
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    
    public function __construct($key, $name)
    {
        $this->id = $key;
        $this->name = $name;
    }


    /**
     * Set id
     *
     * @param string $id
     *
     * @return Game
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
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
     * @return Game
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
}
