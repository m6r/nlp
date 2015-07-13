<?php

namespace VoteAssemblee2015Bundle\Poll;

use AppBundle\Entity\Poll\AbstractPoll;
use AppBundle\Entity\Poll\Election;
use AppBundle\Entity\User;
use AppBundle\Poll\ElectionRuleInterface;

class ElectionRule implements ElectionRuleInterface
{
    /**
     * @inheritdoc
     */
    public function getValidCriterias()
    {
        $regions = array(
            'Alsace',
            'Aquitaine',
            'Auvergne',
            'Basse-Normandie',
            'Bourgogne',
            'Bretagne',
            'Centre',
            'Champagne',
            'Corse',
            'Franche-Comté',
            'Haute-Normandie',
            'Ile-de-France',
            'Languedoc-Roussillon',
            'Limousin',
            'Lorraine',
            'Midi-Pyrénées',
            'Nord-Pas-de-Calais',
            'Pays-de-la-Loire',
            'Picardie',
            'Poitou-Charente',
            'Provence-Alpes-Côte d\'Azur',
            'Rhône-Alpes',
            'Outre-mer - Océan Atlantique',
            'Outre-mer - Océan Indien',
            'Outre-mer - Océan Pacifique',
            'Etranger',
        );

        return array('Assemblée représentative' => $regions);
    }

    public function hasGenderParity()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isAllowedToCandidate(User $user, Election $election)
    {
        if ('Assemblée représentative' !== $election->getGroup()) {
            return false;
        }

        $region = $this->getRegionFromCodePostal($user->getZipCode());

        return $region === $election->getCriteria();
    }

    /**
     * @inheritdoc
     */
    public function isAllowedToVote(User $user, AbstractPoll $election)
    {
        return $this->isAllowedToCandidate($user, $election);
    }

    /**
     * @inheritdoc
     */
    public function getCandidateCriterias(User $user)
    {
        $region = $this->getRegionFromCodePostal($user->getZipCode());

        return array('Assemblée représentative' => array($region));
    }

    /**
     * @inheritdoc
     */
    public function getVoteCriterias(User $user)
    {
        return $this->getCandidateCriterias($user);
    }

    /**
     * @inheritdoc
     */
    public function getVoteNumber(User $user, Election $election)
    {
        return $this->getWinnersNumber($election);
    }

    /**
     * @inheritdoc
     */
    public function getWinnersNumber(Election $election)
    {
        $region = $election->getCriteria();

        $votes = array(
            'Alsace' => 4,
            'Aquitaine' => 6,
            'Auvergne' => 4,
            'Basse-Normandie' => 2,
            'Bourgogne' => 4,
            'Bretagne' => 4,
            'Centre' => 4,
            'Champagne' => 2,
            'Corse' => 2,
            'Franche-Comté' => 2,
            'Haute-Normandie' => 4,
            'Ile-de-France' => 12,
            'Languedoc-Roussillon' => 6,
            'Limousin' => 2,
            'Lorraine' => 4,
            'Midi-Pyrénées' => 6,
            'Nord-Pas-de-Calais' => 4,
            'Pays-de-la-Loire' => 4,
            'Picardie' => 4,
            'Poitou-Charente' => 4,
            'Provence-Alpes-Côte d\'Azur' => 8,
            'Rhône-Alpes' => 8,
            'Outre-mer - Océan Atlantique' => 2,
            'Outre-mer - Océan Indien' => 2,
            'Outre-mer - Océan Pacifique' => 2,
            'Etranger' => 2,
        );

        return $votes[$region];
    }

    /**
     * Récupérer le nom de la région à partir d'un code postal.
     *
     * @param int $codePostal Le code postal
     *
     * @return [type] [description]
     */
    private function getRegionFromCodePostal($codePostal)
    {
        $departement = ($codePostal - ($codePostal % 1000)) / 1000;

        switch ($departement) {
            case 67:
            case 68:
                return 'Alsace';
            case 24:
            case 33:
            case 40:
            case 47:
            case 64:
                return 'Aquitaine';
            case 3:
            case 15:
            case 43:
            case 63:
                return 'Auvergne';
            case 14:
            case 50:
            case 61:
                return 'Basse-Normandie';
            case 21:
            case 58:
            case 71:
            case 89:
                return 'Bourgogne';
            case 22:
            case 29:
            case 35:
            case 56:
                return 'Bretagne';
            case 18:
            case 28:
            case 36:
            case 37:
            case 41:
            case 45:
                return 'Centre';
            case 8:
            case 10:
            case 51:
            case 52:
                return 'Champagne';
            case 20:
                return 'Corse';
            case 25:
            case 39:
            case 70:
            case 90:
                return 'Franche-Comté';
            case 27:
            case 76:
                return 'Haute-Normandie';
            case 75:
            case 77:
            case 78:
            case 91:
            case 92:
            case 93:
            case 94:
            case 95:
                return 'Ile-de-France';
            case 11:
            case 30:
            case 34:
            case 48:
            case 66:
                return 'Languedoc-Roussillon';
            case 19:
            case 23:
            case 87:
                return 'Limousin';
            case 54:
            case 55:
            case 57:
            case 88:
                return 'Lorraine';
            case 9:
            case 12:
            case 31:
            case 32:
            case 46:
            case 65:
            case 81:
            case 82:
                return 'Midi-Pyrénées';
            case 59:
            case 62:
                return 'Nord-Pas-de-Calais';
            case 44:
            case 49:
            case 53:
            case 72:
            case 85:
                return 'Pays-de-la-Loire';
            case 2:
            case 60:
            case 80:
                return 'Picardie';
            case 16:
            case 17:
            case 79:
            case 86:
                return 'Poitou-Charente';
            case 4:
            case 5:
            case 6:
            case 13:
            case 83:
            case 84:
                return 'Provence-Alpes-Côte d\'Azur';
            case 1:
            case 7:
            case 26:
            case 38:
            case 42:
            case 69:
            case 73:
            case 74:
                return 'Rhône-Alpes';
            case 97:
            case 98:
                $departement = ($codePostal - ($codePostal % 100)) / 100;
                if (in_array($departement, array(971, 972, 973, 975, 977), true)) {
                    return 'Outre-mer - Océan Atlantique';
                }
                if (in_array($departement, array(974, 976), true)) {
                    return 'Outre-mer - Océan Indien';
                }
                if (in_array($departement, range(986, 989), true)) {
                    return 'Outre-mer - Océan Pacifique';
                }

                return '';
            case 99:
                return 'Etranger';
            default:
                return '';
        }

        return '';
    }
}
