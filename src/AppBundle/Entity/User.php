<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users", indexes={
 *     @ORM\Index(name="user_email", columns={"user_email"})
 * })
 * @ORM\Entity()
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer", name="user_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true, name="user_login", options={"default"=""})
     */
    private $username;

    /**
     * @ORM\Column(type="string", name="user_level", options={"default"="normal"})
     */
    private $level;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="user_modification")
     */
    private $updated;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="user_date", options={"default"="0000-00-00 00:00:00"})
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=256, name="user_pass", options={"default"=""})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=128, name="user_email", options={"default"=""})
     */
    private $email;

    /**
     * @deprecated
     * @ORM\Column(type="string", length=128, name="user_names", options={"default"=""})
     */
    private $names = '';

    /**
     * @deprecated
     * @ORM\Column(type="decimal", precision=10, scale=2, name="user_karma", nullable=true, options={"default"=0.00})
     */
    private $karma;

    /**
     * @ORM\Column(type="string", length=128, name="user_url", options={"default"=""})
     */
    private $url = '';

    /**
     * @ORM\Column(type="datetime", name="user_lastlogin", options={"default"="0000-00-00 00:00:00"})
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="string", length=64, name="user_facebook", options={"default"=""})
     */
    private $facebook = '';

    /**
     * @ORM\Column(type="string", length=64, name="user_twitter", options={"default"=""})
     */
    private $twitter = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=64, name="user_linkedin", options={"default"=""})
     */
    private $linkedin = '';

    /**
     * @ORM\Column(type="string", length=64, name="user_googleplus", options={"default"=""})
     */
    private $googleplus = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=64, name="user_skype", options={"default"=""})
     */
    private $skype = '';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=64, name="user_pinterest", options={"default"=""})
     */
    private $pinterest = '';

    /**
     * @ORM\Column(type="string", length=64, name="public_email", options={"default"=""})
     */
    private $publicEmail = '';

    /**
     * @ORM\Column(type="string", length=255, name="user_avatar_source", options={"default"=""})
     */
    private $avatarSource = '';

    /**
     * @ORM\Column(type="string", length=20, name="user_ip", nullable=true, options={"default"="0"})
     */
    private $userIP = '0';

    /**
     * @ORM\Column(type="string", length=20, name="user_lastip", nullable=true, options={"default"="0"})
     */
    private $userLastIP = '0';

    /**
     * @ORM\Column(type="datetime", name="last_reset_request", options={"default"="0000-00-00 00:00:00"})
     */
    private $lastResetRequest;

    /**
     * @ORM\Column(type="string", length=255, name="last_reset_code", nullable=true)
     */
    private $lastResetCode;

    /**
     * @ORM\Column(type="string", length=255, name="user_location", nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, name="user_occupation", nullable=true)
     */
    private $occupation;

    /**
     * @ORM\Column(type="string", length=255, name="user_categories", options={"default"=""})
     */
    private $categories = '';

    /**
     * @ORM\Column(type="boolean", length=255, name="user_enabled", options={"default"="1"})
     */
    private $enabled = '1';

    /**
     * @deprecated
     * @ORM\Column(type="string", length=32, name="user_language", nullable=true)
     */
    private $language;

    /**
     * @var string Private information (the regex is for any french number
     *             without prefix, or any foreigner number with international prefix)
     * @ORM\Column(type="string", length=16, name="user_numero_tel", nullable=true)
     *
     * @Assert\Regex("/(^0[1-9][0-9]{8}$)|(^\+(?!33)[0-9]{5,15}$)/")
     */
    private $phoneNumber;

    /**
     * @var string Private information
     * @ORM\Column(type="string", length=32, name="user_nom")
     *
     * @Assert\NotBlank(groups={"candidacy"})
     * @Assert\Length(max=32, groups={"candidacy"})
     */
    private $lastName;

    /**
     * @var string Private information
     * @ORM\Column(type="string", length=32, name="user_prenom")
     *
     * @Assert\NotBlank(groups={"candidacy"})
     * @Assert\Length(max=32, groups={"candidacy"})
     */
    private $firstName;

    /**
     * @var string Private information
     * @ORM\Column(type="string", length=1, name="user_genre", nullable=true)
     *
     * @Assert\Choice(choices={"M", "F"}, groups={"candidacy"})
     */
    private $gender;

    /**
     * @var \Datetime Private information
     * @ORM\Column(type="date", name="user_date_naissance", nullable=true)
     */
    private $birthDate;

    /**
     * @var string Private information
     * @ORM\Column(type="string", length=8, name="user_code_postal")
     *
     * @Assert\Range(min=1000,max=99999)
     */
    private $zipCode;

    /**
     * @var string Private information
     * @ORM\Column(type="string", length=32, name="user_ville", nullable=true)
     */
    private $city;

    /**
     * @var string Private information.
     * @ORM\Column(type="string", length=32, name="user_pays", nullable=true)
     */
    private $country;

    /**
     * @deprecated
     * @ORM\Column(type="boolean", name="user_signature", nullable=true)
     */
    private $signature;

    /**
     * @var string Public information.
     * @ORM\Column(type="text", name="user_biographie", nullable=true)
     */
    private $biography;

    /**
     * Lock during lock period.
     *
     * @var \AppBundle\Entity\Poll\ProfileLock
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Poll\ProfileLock", mappedBy="user")
     */
    private $profileLocked;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = array('ROLE_USER');

        if ('admin' === $this->level) {
            $roles[] = 'ROLE_ADMIN';
        }

        return $roles;
    }

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
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
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
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set lastLogin.
     *
     * @param \DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin.
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
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
     * Set userIP.
     *
     * @param string $userIP
     *
     * @return User
     */
    public function setUserIP($userIP)
    {
        $this->userIP = $userIP;

        return $this;
    }

    /**
     * Get userIP.
     *
     * @return string
     */
    public function getUserIP()
    {
        return $this->userIP;
    }

    /**
     * Set userLastIP.
     *
     * @param string $userLastIP
     *
     * @return User
     */
    public function setUserLastIP($userLastIP)
    {
        $this->userLastIP = $userLastIP;

        return $this;
    }

    /**
     * Get userLastIP.
     *
     * @return string
     */
    public function getUserLastIP()
    {
        return $this->userLastIP;
    }

    /**
     * Set lastResetRequest.
     *
     * @param \DateTime $lastResetRequest
     *
     * @return User
     */
    public function setLastResetRequest($lastResetRequest)
    {
        $this->lastResetRequest = $lastResetRequest;

        return $this;
    }

    /**
     * Get lastResetRequest.
     *
     * @return \DateTime
     */
    public function getLastResetRequest()
    {
        return $this->lastResetRequest;
    }

    /**
     * Set lastResetCode.
     *
     * @param string $lastResetCode
     *
     * @return User
     */
    public function setLastResetCode($lastResetCode)
    {
        $this->lastResetCode = $lastResetCode;

        return $this;
    }

    /**
     * Get lastResetCode.
     *
     * @return string
     */
    public function getLastResetCode()
    {
        return $this->lastResetCode;
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
     * Set enabled.
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
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

    /**
     * @return boolean
     */
    public function isProfileLocked()
    {
        return (null !== $this->profileLocked);
    }

    /**
     * All functions of AdvancedUserInterface start here.
     */

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isAccountNonLocked()
    {
        $confirmed = $this->lastLogin > new \DateTime('00-00-0000 00:00:00');
        $notBlocked = in_array($this->level, array('normal', 'moderator', 'admin'), true);

        return $confirmed && $notBlocked;
    }

    /**
     * @inheritDoc
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}
