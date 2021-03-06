<?php

namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    const SALT = 'zsfd324214sdf2szg3421';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="5", minMessage="Пожалуйста, введите больше {{ limit }}х символов.")
     * @ORM\Column(type="string")
     */
    private $login;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="5", minMessage="Пожалуйста, введите больше {{ limit }}х символов.")
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $avatarPath;
    /**
     * @var Session
     */
    private $session;

    public function getId() {
        return $this->id;
    }
    public function getLogin() {
        return $this->login;
    }
    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }
    public function getPassword($password) {
        return $this->$password = $password;
    }
    public function setPassword($password) {
        $this->password = md5($password . SALT);
        return $this;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->login = $name;
        return $this;
    }
    public function setAvatarPath($avatarPath) {
        $this->avatarPath = $avatarPath;
        return $this;
    }
    public function getSession() {
        return $this->session;
    }
    public function setSession($session) {
        $this->session = $session;
        return $this->session;
    }
}
