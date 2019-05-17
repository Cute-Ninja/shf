<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\AbstractBaseEntity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\User\UserRepository")
 *
 * @UniqueEntity(fields={"username"}, groups={"registration", "update"})
 * @UniqueEntity(fields={"email"})
 */
class User extends AbstractBaseEntity implements UserInterface
{
    public const STATUS_TO_ACTIVATE = 'to-activate';

    public const  ROLE_USER = 'ROLE_USER';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=75, unique=true)
     *
     * @Assert\NotBlank(groups={"registration", "update"})
     * @Assert\Type(
     *     type="alnum",
     *     groups={"registration", "update"},
     *     message="Doit contenir des chiffres ou des lettres. Pas de caracètres spéciaux."
     * )
     * @Assert\Length(min=4, max=15, groups={"registration", "update"})
     *
     * @Serializer\Groups({"default", "test"})
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, unique=true)
     *
     * @Assert\NotBlank(groups={"registration", "update"})
     * @Assert\Email(groups={"registration", "update"})
     *
     * @Serializer\Groups({"default", "test"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @Assert\NotBlank(groups={"registration", "update"})
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",
     *     message="Doit contenir 8 caractères avec au moins une majuscule, une minuscule et un chiffre",
     *     groups={"registration", "update"}
     * )
     */
    private $password;

    /**
     * @var bool
     *
     * @Serializer\Groups({"default", "test"})
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin = false;

    /**
     * @var string
     *
     * @Serializer\Groups({"admin"})
     * @ORM\Column(name="confirmation_key", type="string", length=255, nullable=true, unique=true)
     */
    private $confirmationKey;

    /**
     * @var DateTime|null
     * @ORM\Column(name="confirmation_key_expiration", type="datetime", nullable=true)
     */
    private $confirmationKeyExpiration;

    /**
     * @var string[]
     *
     * @ORM\Column(name="roles", type="simple_array")
     * @Serializer\Groups({"admin", "test"})
     */
    private $roles;

    /**
     * @var UserStats
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\User\UserStats")
     * @ORM\JoinColumn(name="user_stats_id", referencedColumnName="id")
     *
     * @Serializer\Groups({"userStats"})
     */
    private $userStats;

    protected function getDefaultStatus(): string
    {
        return self::STATUS_TO_ACTIVATE;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getConfirmationKey(): ?string
    {
        return $this->confirmationKey;
    }

    public function setConfirmationKey(?string $confirmationKey): void
    {
        $this->confirmationKey = $confirmationKey;
    }

    public function getConfirmationKeyExpiration(): ?DateTime
    {
        return $this->confirmationKeyExpiration;
    }

    public function setConfirmationKeyExpiration(?DateTime $confirmationKeyExpiration): void
    {
        $this->confirmationKeyExpiration = $confirmationKeyExpiration;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function hasRole(string $role): bool
    {
        if (in_array(self::ROLE_SUPER_ADMIN, $this->getRoles(), true)) {
            return true;
        }

        return in_array($role, $this->getRoles(), true);
    }

    public function getUserStats(): UserStats
    {
        return $this->userStats;
    }

    public function setUserStats(UserStats $userStats): void
    {
        $this->userStats = $userStats;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): ?string
    {
        return null;
    }

    public static function basicUserRoles()
    {
        return ['ROLE_TAG_READ'];
    }
}
