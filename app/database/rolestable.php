<?php

if ($dropTables === true)
{
    $query = "DROP TABLE IF EXISTS `roles`";
    mysqlQuery($query);
}

/**
 * Create a roles table in the database
 */
$query = "CREATE TABLE IF NOT EXISTS `roles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(80) NOT NULL,
    `created` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated` timestamp DEFAULT CURRENT_TIMESTAMP,
    `deleted` timestamp,
    `created_by` int(11) NOT NULL,
    `updated_by` int(11),
    `deleted_by` int(11),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

mysqlQuery($query);

?>