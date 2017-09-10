<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Symfony\Component\Serializer\Annotation as Serializer;
use BaseBundle\Lib\Serialization\Annotation\Normal;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="fos_user")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Loggable
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        $this->achievements = new ArrayCollection();
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"full", "concise"})
     */
    protected $id;

    /**
     * Hook softdeleteable behavior
     * deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     * @Serializer\Groups({"full", "concise"})
     */
    private $displayedName;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Achievement")
     * @ORM\JoinTable(name="user_achievements",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="achievement_id", referencedColumnName="id")}
     *      )
     * @Serializer\Groups({"full"})
     * @Normal\Entity(className="UserBundle\Entity\Achievement", isMultiple=true)
     */
    private $achievements;

    /**
     * @return Collection|Achievement[]
     */
    public function getAchievements(): Collection
    {
        return $this->achievements;
    }

    /**
     * @param Achievement $achievement
     * @return User
     */
    public function addAchievement(Achievement $achievement): User
    {
        if (!in_array($achievement, $this->achievements->toArray())) {
            $this->achievements->add($achievement);
        }

        return $this;
    }

    /**
     * @param Achievement $achievement
     * @return User
     */
    public function removeAchievement(Achievement $achievement): User
    {
        $this->achievements->remove($achievement);

        return $this;
    }

    /**
     * @return User
     */
    public function removeAllAchievements(): User
    {
        $this->achievements = new ArrayCollection();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDisplayedName() {
        return $this->displayedName;
    }

    /**
     * @param mixed $displayedName
     */
    public function setDisplayedName($displayedName) {
        $this->displayedName = $displayedName;
    }
}