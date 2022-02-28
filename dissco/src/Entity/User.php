<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="already_in_use")
 * @UniqueEntity(fields={"email"}, message="already_in_use")
 * @UniqueEntity(fields={"mobileNo"}, message="already_in_use")
 * @method string getUserIdentifier()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */

    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9._\d]+$/", message="invalid_username")
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "username must be at least {{ limit }} characters long",
     * )
     * @Assert\NotBlank
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/\+[0-9]*$/")
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/^[1-9][0-9]{9}$/")
     */
    private $mobileNo;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/", message="Password should contain 1 upper case letter, 1 lower case letter, and 1 number")
     */
    private $password;

    /**
     * The salt to use for hashing.
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $passportNumber;

    /**
     * @ORM\Column(type="blob")
     *
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/jpg" ,"image/png"},
     *     mimeTypesMessage = "Please upload a valid image",
     *     maxSize = "1024k",
     *     binaryFormat=true
     * )
     * @Assert\NotBlank
     */
    private $passportImage;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = ['ROLE_USER'];

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled = 1;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * parameter for login_check in jwt
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param mixed $family
     */
    public function setFamily($family): void
    {
        $this->family = $family;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * @param mixed $mobileNo
     */
    public function setMobileNo($mobileNo): void
    {
        $this->mobileNo = $mobileNo;
    }

    /**
     * @return mixed
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * @param mixed $passportNumber
     */
    public function setPassportNumber($passportNumber): void
    {
        $this->passportNumber = $passportNumber;
    }

    /**
     * @return mixed
     */
    public function getPassportImage()
    {
        return $this->passportImage;
    }

    /**
     * @param mixed $passportImage
     */
    public function setPassportImage($passportImage): void
    {
        $this->passportImage = $passportImage;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
