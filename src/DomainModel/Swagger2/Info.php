<?php
/**
 * File was created 15.10.2015 17:17
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
namespace PeekAndPoke\Component\Rip\DomainModel\Swagger2;

use PeekAndPoke\Component\Slumber\Annotation\Slumber;

/**
 * Info
 *
 * @author Karsten J. Gerber <kontakt@karsten-gerber.de>
 */
class Info
{
    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $description;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $version;

    /**
     * @var string
     *
     * @Slumber\AsString()
     */
    private $title;

    /**
     * @var Contact
     *
     * @Slumber\AsObject(Contact::class)
     */
    private $contact;

    /**
     * @var License
     *
     * @Slumber\AsObject(License::class)
     */
    private $licence;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     *
     * @return $this
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return License
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * @param License $licence
     *
     * @return $this
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
    }
}
