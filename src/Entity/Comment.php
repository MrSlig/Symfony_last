<?php

namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $text;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $date;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $post_id;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $user_id;
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $subcomment_id;
    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    public function getId() {
        return $this->id;
    }
    public function getText() {
        return $this->text;
    }
    public function setText($text) {
        $this->text = $text;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    public function getPostId() {
        return $this->post_id;
    }
    public function setPostId($post_id) {
        $this->post_id = $post_id;
        return $this;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }
    public function getSubcommentId() {
        return $this->subcomment_id;
    }
    public function setSubcommentId($subcomment_id) {
        $this->subcomment_id = $subcomment_id;
        return $this;
    }
    public function getPost() {
        return $this->post;
    }
    public function setPost($post) {
        $this->post = $post;
        return $this;
    }
}
