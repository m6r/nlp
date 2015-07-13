<?php

namespace AppBundle\Command;

use libphonenumber\PhoneNumberFormat;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpgradeCommand extends ContainerAwareCommand
{
    /**
     * @var array
     */
    protected $versions = array('0.1', '0.2');

    protected function configure()
    {
        $this
            ->setName('app:db:upgrade')
            ->setDescription('Upgrade the database between versions.')
            ->addArgument('start-version', InputArgument::REQUIRED, 'The version to upgrade from.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $version = $input->getArgument('start-version');

        $key = array_search($version, $this->versions, true);

        if (false === $key) {
            throw new \RuntimeException('This version does not exist.');
        }

        for ($i = $key; $i < count($this->versions) - 1; $i++) {
            $output->writeln('Upgrading from '.$this->versions[$i].' to '.$this->versions[$i + 1]);

            $conn = $this->getContainer()->get('database_connection');
            $conn->beginTransaction();

            try {
                $upgradeMethod = 'v'.str_replace('.', 'dot', $this->versions[$i]).
                    'to'.str_replace('.', 'dot', $this->versions[$i + 1]);

                call_user_func(array(
                    $this,
                    $upgradeMethod,
                ));

                $conn->commit();
            } catch (\Exception $e) {
                $conn->rollback();

                $output->writeln('Upgrade from '.$this->versions[$i].' failed.');
                throw $e;
            }
        }
    }

    private function v0dot1To0dot2()
    {
        $conn = $this->getContainer()->get('database_connection');
        $conn->prepare('ALTER TABLE `pligg_widgets` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_votes` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_trackbacks` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_totals` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_tag_cache` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_tags` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_saved_links` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_redirects` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_old_urls` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_modules` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_misc_data` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_messages` ENGINE=InnoDB')->execute();
        //$conn->prepare('ALTER TABLE `pligg_links` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_friends` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_formulas` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_config` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_comments` ENGINE=InnoDB')->execute();
        $conn->prepare('ALTER TABLE `pligg_categories` ENGINE=InnoDB')->execute();
        $conn->prepare(
            'ALTER TABLE pligg_users
            ADD user_phone_confirmed TINYINT(1) NOT NULL,
            ADD user_phone_code VARCHAR(255) DEFAULT NULL,
            ADD username_canonical VARCHAR(255) NOT NULL,
            ADD email_canonical VARCHAR(255) NOT NULL,
            ADD salt VARCHAR(255) NOT NULL,
            ADD locked TINYINT(1) NOT NULL,
            ADD expired TINYINT(1) NOT NULL,
            ADD expires_at DATETIME DEFAULT NULL,
            ADD confirmation_token VARCHAR(255) DEFAULT NULL,
            ADD password_requested_at DATETIME DEFAULT NULL,
            ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
            ADD credentials_expired TINYINT(1) NOT NULL,
            ADD credentials_expire_at DATETIME DEFAULT NULL,
            ADD profile_frozen TINYINT(1) DEFAULT \'0\' NOT NULL,
            CHANGE user_numero_tel user_phone VARCHAR(35) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\',
            CHANGE user_nom user_last_name VARCHAR(32) NOT NULL,
            CHANGE user_prenom user_first_name VARCHAR(32) NOT NULL,
            CHANGE user_ville user_city VARCHAR(32) DEFAULT NULL,
            CHANGE user_pays user_country VARCHAR(32) DEFAULT NULL,
            # CHANGE user_modification user_modification DATETIME NOT NULL,
            CHANGE user_genre user_gender VARCHAR(1) DEFAULT NULL,
            CHANGE user_date_naissance user_birth_date DATE DEFAULT NULL,
            CHANGE user_code_postal user_postcode VARCHAR(8) NOT NULL,
            CHANGE user_biographie user_biography LONGTEXT DEFAULT NULL'
        )->execute();
        $conn->prepare(
            'UPDATE pligg_users
            SET email_canonical = LOWER(user_email),
            username_canonical = LOWER(user_login),
            roles = "a:0:{}"
            WHERE 1'
        )->execute();
        $conn->prepare('CREATE UNIQUE INDEX UNIQ_15F8030192FC23A8 ON pligg_users (username_canonical)')->execute();
        $conn->prepare('CREATE UNIQUE INDEX UNIQ_15F80301A0D96FBF ON pligg_users (email_canonical)')->execute();
        $conn->prepare('ALTER TABLE pligg_links CHANGE link_modified link_modified DATETIME NOT NULL')->execute();

        $sql = 'SELECT user_id, user_phone FROM pligg_users';
        $stmt = $conn->query($sql);

        while ($user = $stmt->fetch()) {
            $phoneUtil = $this->getContainer()->get('libphonenumber.phone_number_util');

            if ($phoneUtil->isPossibleNumber($user['user_phone'], 'FR')) {
                $phoneNumber = $phoneUtil->parse($user['user_phone'], 'FR');
                $phoneNumber = $phoneUtil->format($phoneNumber, PhoneNumberFormat::E164);
            } else {
                $phoneNumber = null;
            }

            $sql = 'UPDATE pligg_users SET user_phone = :phone WHERE user_id = :id';
            $updateStmt = $conn->prepare($sql);
            $updateStmt->bindValue('phone', $phoneNumber);
            $updateStmt->bindValue('id', $user['user_id']);
            $updateStmt->execute();
        }
    }
}
