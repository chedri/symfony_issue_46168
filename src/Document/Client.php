<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use SLLH\IsoCodesValidator\Constraints as IsoCodesAssert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Mapping\ClassMetadata;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

use App\Trait\Entity;
use App\Interface\EntityInterface;

/**
 * @MongoDB\Document()
 */
class Client implements UserInterface, PasswordAuthenticatedUserInterface, EntityInterface, GroupSequenceProviderInterface, \Serializable
{
    const TYPE_CUSTOMER = 'customer';
    const TYPE_COMPANY = 'company';
    const TYPE_RESELLER = 'reseller';
    const TYPE_OTHER = 'other';

    use Entity;

    /**
     * @MongoDB\Id(strategy="NONE", type="string")
     */
    protected $username;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\Choice(choices = {"customer", "company", "reseller", "other"}, message = "user_type_invalid")
     */
    protected $type = 'customer';

    /**
     * @MongoDB\Field(type="string")
     */
    protected $password;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $roles;

    /**
     *
     */
    public function __construct($username, $password, $salt, array $roles)
    {
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * Needed for the interface
     */
    public function eraseCredentials()
    {
    }

    /**
     * Get user ID
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->username;
    }

    /**
     * Set user ID
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get user ID
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * Set user type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get user type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get roles
     *
     * @return array $roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->setGroupSequenceProvider(true);
    }

    public function getGroupSequence(): array|GroupSequence
    {
        $groups = ['Form', 'Default', 'Client', 'EmbeddedClientProfile'];
        $profileGroups = [];
        if ($this->hasRole('ROLE_CUSTOMER')) {
            $profileGroups[] = 'withClientMobilePhone';
        }
        if (Client::isTypeCompany($this->getType())) {
            $profileGroups[] = 'typeCompany';
        }
        $groups[] = $profileGroups;

        return $groups;
    }

    public function serialize()
    {
        return serialize([
            'username' => $this->username,
            'salt' => null,
            'password' => $this->password
        ]);
    }

    public function unserialize($data)
    {
        $data = unserialize($data);

        if (is_array($data)) {
            if (isset($data['username'])) {
                $this->username = $data['username'];
            }

            if (isset($data['salt'])) {
                // $this->salt = $data['salt'];
            }

            if (isset($data['password'])) {
                $this->password = $data['password'];
            }
        }
    }
}
