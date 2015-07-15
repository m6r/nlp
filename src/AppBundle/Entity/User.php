<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use libphonenumber\PhoneNumber;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users", indexes={
 *     @ORM\Index(name="user_email", columns={"user_email"})
 * })
 * @ORM\Entity()
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="username",
 *         column=@ORM\Column(
 *             name="user_login",
 *             type="string",
 *             length=32,
 *             unique=true,
 *             options={"default"=""}
 *         )
 *     ),
 *     @ORM\AttributeOverride(name="password",
 *         column=@ORM\Column(
 *             name="user_pass",
 *             type="string",
 *             length=256,
 *             options={"default"=""}
 *         )
 *     ),
 *     @ORM\AttributeOverride(name="email",
 *         column=@ORM\Column(
 *             name="user_email",
 *             type="string",
 *             length=128,
 *             options={"default"=""}
 *         )
 *     ),
 *     @ORM\AttributeOverride(name="lastLogin",
 *         column=@ORM\Column(
 *             name="user_lastlogin",
 *             type="datetime",
 *             options={"default"="0000-00-00 00:00:00"}
 *         )
 *     ),
 *     @ORM\AttributeOverride(name="enabled",
 *         column=@ORM\Column(
 *             name="user_enabled",
 *             type="boolean",
 *             length=255,
 *             options={"default"="1"}
 *         )
 *     )
 * })
 * @UniqueEntity("phoneNumber", groups={"Registration", "freeze"}, message="account.phone.already_used")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer", name="user_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="user_level", options={"default"="normal"})
     */
    protected $level = 'normal';

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="user_modification")
     */
    protected $updated;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="user_date", options={"default"="0000-00-00 00:00:00"})
     */
    protected $created;

    /**
     * @deprecated
     * @ORM\Column(type="string", length=128, name="user_names", options={"default"=""})
     */
    protected $names = '';

    /**
     * @deprecated
     * @ORM\Column(type="decimal", precision=10, scale=2, name="user_karma", nullable=true, options={"default"=0.00})
     */
    protected $karma;

    /**
     * @ORM\Column(type="string", length=128, name="user_url", options={"default"=""})
     */
    protected $url = '';

    /**
     * @ORM\Column(type="string", length=64, name="user_facebook", options={"default"=""})
     */
    protected $facebook = '';

    /**
     * @ORM\Column(type="string", length=64, name="user_twitter", options={"default"=""})
     */
    protected $twitter = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=64, name="user_linkedin", options={"default"=""})
     */
    protected $linkedin = '';

    /**
     * @ORM\Column(type="string", length=64, name="user_googleplus", options={"default"=""})
     */
    protected $googleplus = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=64, name="user_skype", options={"default"=""})
     */
    protected $skype = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=64, name="user_pinterest", options={"default"=""})
     */
    protected $pinterest = '';

    /**
     * @ORM\Column(type="string", length=64, name="public_email", options={"default"=""})
     */
    protected $publicEmail = '';

    /**
     * @ORM\Column(type="string", length=255, name="user_avatar_source", options={"default"=""})
     */
    protected $avatarSource = '';

    /**
     * @ORM\Column(type="string", length=20, name="user_ip", nullable=true, options={"default"="0"})
     * @Gedmo\IpTraceable(on="create")
     */
    protected $IP = '0';

    /**
     * @ORM\Column(type="string", length=20, name="user_lastip", nullable=true, options={"default"="0"})
     */
    protected $lastIP = '0';

    /**
     * @deprecated
     * @ORM\Column(type="datetime", name="last_reset_request", options={"default"="0000-00-00 00:00:00"})
     */
    protected $lastResetRequest;

    /**
     * @deprecated
     * @ORM\Column(type="string", length=255, name="last_reset_code", nullable=true)
     */
    protected $lastResetCode;

    /**
     * @ORM\Column(type="string", length=255, name="user_location", nullable=true)
     */
    protected $location;

    /**
     * @ORM\Column(type="string", length=255, name="user_occupation", nullable=true)
     */
    protected $occupation;

    /**
     * @ORM\Column(type="string", length=255, name="user_categories", options={"default"=""})
     */
    protected $categories = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=32, name="user_language", nullable=true)
     */
    protected $language;

    /**
     * @var PhoneNumber Private information
     *
     * @ORM\Column(type="phone_number", name="user_phone", nullable=true)
     * @Assert\NotBlank(groups={"Registration"})
     * @AssertPhoneNumber(defaultRegion="FR", type="mobile", groups={"Registration"})
     */
    protected $phoneNumber;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="user_phone_confirmed")
     */
    protected $phoneConfirmed;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="user_phone_code", nullable=true)
     */
    protected $phoneCode;

    /**
     * @var string Private information
     * @ORM\Column(type="string", length=32, name="user_last_name")
     *
     * @Assert\NotBlank(groups={"candidacy", "Registration"})
     * @Assert\Length(max=32, groups={"candidacy", "Registration"})
     */
    protected $lastName;

    /**
     * @var string Private information
     *
     * @ORM\Column(type="string", length=32, name="user_first_name")
     * @Assert\NotBlank(groups={"candidacy", "Registration"})
     * @Assert\Length(max=32, groups={"candidacy", "Registration"})
     */
    protected $firstName;

    /**
     * @var string Private information
     *
     * @ORM\Column(type="string", length=1, name="user_gender", nullable=true)
     * @Assert\NotBlank(groups={"candidacy"})
     * @Assert\Choice(choices={"M", "F"}, groups={"candidacy"})
     */
    protected $gender;

    /**
     * @var \Datetime Private information
     *
     * @ORM\Column(type="date", name="user_birth_date", nullable=true)
     * @Assert\NotBlank(groups={"Registration"})
     * @Assert\Date()
     * @Assert\LessThan("now")
     */
    protected $birthDate;

    /**
     * @var string Private information
     *
     * @ORM\Column(type="string", length=8, name="user_postcode")
     * @Assert\NotBlank(groups={"Registration", "freeze"})
     * @Assert\Range(min=1000,max=99999, groups={"Registration", "freeze"})
     */
    protected $postCode;

    /**
     * @var string Private information
     *
     * @ORM\Column(type="string", length=32, name="user_city", nullable=true)
     */
    protected $city;

    /**
     * @var string Private information.
     *
     * @ORM\Column(type="string", length=32, name="user_country", nullable=true)
     * @Assert\NotBlank(groups={"Registration"})
     * @Assert\Country(groups={"Registration"})
     */
    protected $country;

    /**
     * @deprecated
     *
     * @ORM\Column(type="boolean", name="user_signature", nullable=true)
     */
    protected $signature;

    /**
     * @var string Public information.
     *
     * @ORM\Column(type="text", name="user_biography", nullable=true)
     */
    protected $biography;

    /**
     * Lock during lock period.
     *
     * @var \AppBundle\Entity\Poll\ProfileLock
     *
     * @ORM\Column(type="boolean", name="profile_frozen", options={"default"=false})
     */
    protected $profileFrozen;

    public function __construct()
    {
        parent::__construct();

        $this->profileFrozen = false;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return substr($this->password, 0, 9);
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonLocked()
    {
        $notBlocked = in_array($this->level, array('normal', 'moderator', 'admin'), true);

        return $notBlocked && parent::isAccountNonLocked();
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = parent::getRoles();

        if ('admin' === $this->level) {
            $roles[] = 'ROLE_ADMIN';
        }

        $roles[] = ($this->isPhoneConfirmed() ? 'ROLE_VOTER' : 'ROLE_PHONE_NOT_CONFIRMED');

        return array_unique($roles);
    }

    /**
     * Find avatar path.
     *
     * @param string $size large, small or original
     *
     * @return string relative URL of the image
     */
    public function getAvatarPath($size)
    {
        if (!in_array($size, array('large', 'small', 'original'), true)) {
            throw new \InvalidArgumentException('$size must be large small, or original');
        }

        if ('small' === $size) {
            $size = '32';
        } elseif ('large' === $size) {
            $size = '100';
        }

        if ('useruploaded' === $this->avatarSource) {
            $path = __DIR__.'/../../../web/avatars/user_uploaded/'.$this->id.'_'.$size.'.jpg';
            clearstatcache();
            if (file_exists($path)) {
                return 'avatars/user_uploaded/'.$this->id.'_'.$size.'.jpg';
            }
        }

        return 'avatars/m6r_'.('small' === $size ? '32' : '100').'.png';
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneConfirmed = false;
        $this->phoneCode = null;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set phone code.
     *
     * @param string $code
     *
     * @return User
     */
    public function setPhoneCode($code)
    {
        $this->phoneCode = $code;
    }

    /**
     * Get phone code.
     *
     * @return string
     */
    public function getPhoneCode()
    {
        return $this->phoneCode;
    }

    /**
     * Get phoneConfirmed.
     *
     * @return bool
     */
    public function isPhoneConfirmed()
    {
        return $this->phoneConfirmed;
    }

    /**
     * Set phoneConfirmed.
     *
     * @param bool
     *
     * @return User
     */
    public function setPhoneConfirmed($phoneConfirmed)
    {
        $this->phoneConfirmed = $phoneConfirmed;

        return $this;
    }

    /**
     * Set avatar_source.
     *
     * @param string $avatarSource
     *
     * @return User
     */
    public function setAvatarSource($avatarSource)
    {
        $this->avatarSource = $avatarSource;

        return $this;
    }

    /**
     * Get avatar_source.
     *
     * @return string
     */
    public function getAvatarSource()
    {
        return $this->avatarSource;
    }

    /**
     * Set IP.
     *
     * @param string $IP
     *
     * @return User
     */
    public function setIP($IP)
    {
        $this->IP = $IP;

        return $this;
    }

    /**
     * Get IP.
     *
     * @return string
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * Set lastIP.
     *
     * @param string $lastIP
     *
     * @return User
     */
    public function setLastIP($lastIP)
    {
        $this->lastIP = $lastIP;

        return $this;
    }

    /**
     * Get lastIP.
     *
     * @return string
     */
    public function getLastIP()
    {
        return $this->lastIP;
    }

    /**
     * Get profileFrozen.
     *
     * @return bool
     */
    public function isProfileFrozen()
    {
        return $this->profileFrozen;
    }

    /**
     * Set profileFrozen.
     *
     * @param bool
     *
     * @return User
     */
    public function setProfileFrozen($profileFrozen)
    {
        $this->profileFrozen = $profileFrozen;

        return $this;
    }

    /**
     * @param string $postCode
     */
    public function setZipCode($postCode)
    {
        $this->postCode = $postCode;
    }

    public function setPostCode($postCode)
    {
        return $this->setZipCode($postCode);
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->postCode;
    }

    public function getPostCode()
    {
        return $this->getZipCode();
    }

    /**
     * Set names.
     *
     * @param string $names
     *
     * @return User
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
    }

    /**
     * Get names.
     *
     * @return string
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Set karma.
     *
     * @param string $karma
     *
     * @return User
     */
    public function setKarma($karma)
    {
        $this->karma = $karma;

        return $this;
    }

    /**
     * Get karma.
     *
     * @return string
     */
    public function getKarma()
    {
        return $this->karma;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return User
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set facebook.
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter.
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter.
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set linkedin.
     *
     * @param string $linkedin
     *
     * @return User
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin.
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set googleplus.
     *
     * @param string $googleplus
     *
     * @return User
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;

        return $this;
    }

    /**
     * Get googleplus.
     *
     * @return string
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }

    /**
     * Set skype.
     *
     * @param string $skype
     *
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype.
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set pinterest.
     *
     * @param string $pinterest
     *
     * @return User
     */
    public function setPinterest($pinterest)
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * Get pinterest.
     *
     * @return string
     */
    public function getPinterest()
    {
        return $this->pinterest;
    }

    /**
     * Set publicEmail.
     *
     * @param string $publicEmail
     *
     * @return User
     */
    public function setPublicEmail($publicEmail)
    {
        $this->publicEmail = $publicEmail;

        return $this;
    }

    /**
     * Get publicEmail.
     *
     * @return string
     */
    public function getPublicEmail()
    {
        return $this->publicEmail;
    }

    /**
     * Set location.
     *
     * @param string $location
     *
     * @return User
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set occupation.
     *
     * @param string $occupation
     *
     * @return User
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation.
     *
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set categories.
     *
     * @param string $categories
     *
     * @return User
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories.
     *
     * @return string
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set language.
     *
     * @param string $language
     *
     * @return User
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthDate.
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate.
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set biography.
     *
     * @param string $biography
     *
     * @return User
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * Get biography.
     *
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}
