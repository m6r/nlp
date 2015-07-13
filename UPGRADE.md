# Database upgrades

Rather than using Doctrine migrations which is still unstable, we manage upgrade
by running app:db:upgrade command. Compatibility is only guaranteed with
MySQL.

