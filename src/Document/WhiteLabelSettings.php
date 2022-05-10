<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

use App\Trait\Entity;
use App\Interface\EntityInterface;

/**
 * @MongoDB\Document()
 */
class WhiteLabelSettings implements EntityInterface
{
    use Entity;

    /**
     * @MongoDB\Id(strategy="AUTO", type="string")
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\ReferenceOne(targetDocument="App\Document\Client", inversedBy="username", storeAs="id")
     */
    protected $owner;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * Set the id
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the owner
     *
     * @param ClientBundle\Document\Client $owner
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get the owner
     *
     * @return ClientBundle\Document\Client $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set the name (only for administration)
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
}
