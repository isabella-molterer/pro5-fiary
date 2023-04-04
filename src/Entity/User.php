<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="benutzer")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="idbenutzer", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096, groups = {"Default"})
     */
    private $plainPassword;

    private $newPassword;
    private $oldPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getUserInitials() {
        if ($this->getFirstName() && $this->getLastName()) {
            $initials = $this->getFirstName()[0] . $this->getLastName()[0];
            return $initials;
        }
        return null;
    }

    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastname;
    }

    public function getNewPassword(){
        return $this->newPassword;
    }

    public function setNewPassword($password)
    {
        $this->newPassword = $password;
    }

    public function getOldPassword(){
        return $this->oldPassword;
    }

    public function setOldPassword($password)
    {
        $this->oldPassword = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        $this->oldPassword = $password;
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
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles = [];

    public function getHighestRole($role_array)
    {
        $rolesSortedByImportance = ['ROLE_ADMIN', 'ROLE_REGISTERED', 'ROLE_USER'];
        foreach ($rolesSortedByImportance as $role)
        {
            if (in_array($role, $role_array))
            {
                return $role;
            }
        }
        return false;
    }

    public static function getRoleOptions()
    {
        return ['User' => 'ROLE_USER', 'Registered' =>'ROLE_REGISTERED', 'Admin' => 'ROLE_ADMIN'];
    }

    public function getRoles(){
        $tmpRoles = $this->roles;

        if(in_array('ROLE_USER', $tmpRoles) === false) {
            $tmpRoles[] = 'ROLE_USER';
            if ($this->getUsername() === 'admin') {
                $tmpRoles[] = 'ROLE_ADMIN';
            }
        }
       return $tmpRoles;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }

    public function getSalt(){
        return null;
    }

    public function eraseCredentials(){}

    public function serialize(){
      return serialize([
        $this->id,
        $this->username,
        $this->email,
        $this->password,
      ]);
    }

    public function unserialize($string){
      list(
        $this->id,
        $this->username,
        $this->email,
        $this->password,
        ) = unserialize($string, ['allowed_classes' => false]);
    }
}
