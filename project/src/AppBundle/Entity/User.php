<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User implements AdvancedUserInterface, \Serializable
{
    private $id;
    
    // Authentication data
    private $email;
    private $password;
    private $plainpassword;
    private $roles;
    private $enabled;
    
    // Other data
    private $name;
    
    // Associations
    private $characters;
    private $memberships;
    
    
    // Constructor
    public function __construct() {
        $this->roles = array('ROLE_USER');
        $this->plainpassword = FALSE;
        $this->enabled = FALSE;
        
        $this->characters = new ArrayCollection();
        $this->memberships = new ArrayCollection();
    }

    //
    // METHODS
    //

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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set roles
     *
     * @param array $roles
     */
    public function setRoles($roles) 
    {
        return $this->roles = $roles;
    }
    
    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /**
     * Set passwordPlain
     *
     * @param boolean $passwordPlain
     *
     * @return boolean
     */
    public function setPasswordPlain($passwordPlain)
    {
        $this->passwordPain = $passwordPlain;

        return $this;
    }

    /**
     * Get passwordPlain
     *
     * @return boolean
     */
    public function isPasswordPlain()
    {
        return $this->passwordPlain;
    }
    
    /**
     * Enable or disable an user
     *
     * @param boolean $enabled
     *
     */
    public function setEnabled($enabled)
    {
        return $this->enabled=$enabled;
    }

    /**
     * Tells if the user is enabled
     *
     * @return boolean
     */
    public function isEnabled() 
    {
        return $this->enabled;
    }
    
    /**
     * Get the ussername
     *
     * @return string that happens to be the email
     */
    public function getUsername() {
        return $this->email;
    }
    
    public function serialize() 
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->enabled,
        ));
    }
    
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->enabled,
        ) = unserialize($serialized);
    }
    
    public function isAccountNonExpired() 
    {
        return TRUE;
    }

    public function isAccountNonLocked() 
    {
        return TRUE;
    }

    public function isCredentialsNonExpired() 
    {
        return TRUE;
    }
    
    public function getSalt()
    {
        return NULL;
    }
    
    public function eraseCredentials()
    {
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Add character
     *
     * @param \AppBundle\Entity\Character $character
     *
     * @return User
     */
    public function addCharacter(\AppBundle\Entity\Character $character)
    {

        
        if(!$this->characters->contains($character)) {
            $character->setUser($this);
            $this->characters[] = $character;
        }

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
     * Set plainpassword
     *
     * @param boolean $plainpassword
     *
     * @return User
     */
    public function setPlainpassword($plainpassword)
    {
        $this->plainpassword = $plainpassword;

        return $this;
    }

    /**
     * Get plainpassword
     *
     * @return boolean
     */
    public function getPlainpassword()
    {
        return $this->plainpassword;
    }



    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add membership
     *
     * @param \AppBundle\Entity\Membership $membership
     *
     * @return User
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
