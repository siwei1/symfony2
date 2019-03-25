<?php
namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AdminBundle\Entity\AdminUserRepository")
 * @ORM\Table(name="admin_user")
 * @ORM\HasLifecycleCallbacks()
 */
class AdminUser implements UserInterface,\Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue("AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=50)
     * @Assert\NotBlank(message="用户名不能为空")
     */
    protected $user_name;

    /**
     * @ORM\Column(type="string",length=64)
     * @Assert\NotBlank(message="密码不能为空")
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $last_login_time;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

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
     * Set user_name
     *
     * @param string $userName
     * @return AdminUser
     */
    public function setUserName($userName)
    {
        $this->user_name = $userName;

        return $this;
    }

    /**
     * Get user_name
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return AdminUser
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return AdminUser
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = new \DateTime('now');
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return AdminUser
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    /**
     * @ORM\PrePersist()
     */
    public function perPersist()
    {
        if($this->created_at == null)
        {
            $this->setCreatedAt(new \DateTime('now'));
        }
        $this->setUpdatedAt(new \DateTime('now'));
    }

    /**
     * @ORM\PreUpdate()
     */
    public function PreUpdate()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }

    /**
     * Set last_login_time
     *
     * @param \DateTime $lastLoginTime
     * @return AdminUser
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->last_login_time = $lastLoginTime;

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->user_name,
            $this->password
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->user_name,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * Get last_login_time
     *
     * @return \DateTime 
     */
    public function getLastLoginTime()
    {
        return $this->last_login_time ? $this->last_login_time->format('Y-m-d H:i:s') : '';
    }

    public function getRoles()
    {
        return ["ROLE_ADMIN"];
    }

    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


}
