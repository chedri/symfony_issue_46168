<?php

namespace App\Trait;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

trait Entity
{
    /**
     * @MongoDB\Field(type="date")
     */
    protected $cdate;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $mdate;

    /**
     * @MongoDB\Field(type="bool")
     */
    protected $isDeleted = false;

    /**
     * @MongoDB\Field(type="bool")
     */
    protected $isActive = true;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\ReferenceOne(targetDocument="ClientBundle\Document\Client", inversedBy="id", storeAs="id")
     */
    protected $creator;

    /**
     * Set the information when the document was created
     *
     * @param DateTime $cdate
     * @return $this
     */
    public function setCdate($cdate)
    {
        if (!($cdate instanceof \DateTime)) {
            $this->cdate = new \DateTime($cdate);
        } else {
            $this->cdate = $cdate;
        }

        return $this;
    }

    /**
     * Get the information when the document was created
     *
     * @return DateTime $cdate
     */
    public function getCdate()
    {
        if ($this->cdate && !($this->cdate instanceof \DateTime)) {
            return new \DateTime($this->cdate);
        }

        return $this->cdate;
    }

    /**
     * Set the information when the document was latest modified
     *
     * @param DateTime $mdate
     * @return $this
     */
    public function setMdate($mdate)
    {
        if (!($mdate instanceof \DateTime)) {
            $this->mdate = new \DateTime($mdate);
        } else {
            $this->mdate = $mdate;
        }

        return $this;
    }

    /**
     * Get the information when the document was latest modified
     *
     * @return DateTime $mdate
     */
    public function getMdate()
    {
        if ($this->mdate && !($this->mdate instanceof \DateTime)) {
            return new \DateTime($this->mdate);
        }

        return $this->mdate;
    }

    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = is_null($isDeleted) ? false : (is_bool($isDeleted) ? $isDeleted : false);
        return $this;
    }

    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = is_null($isActive) ? false : (is_bool($isActive) ? $isActive : true);
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the information who created this document
     *
     * @param ClientBundle\Document\Client $creator
     * @return $this
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * Get the information who created this document
     *
     * @return ClientBundle\Document\Client $creator
     */
    public function getCreator()
    {
        return $this->creator;
    }
}
