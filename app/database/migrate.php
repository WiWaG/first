<?php

/**
 * Check for files which holds database queries to create scheme's
 * @param $dropTable (default = false) set to true to drop all tables and create it again
 */
function migrateDatabase($dropTables = false) : void
{
    // get files from current directory
    $files = scandir(__DIR__, SCANDIR_SORT_ASCENDING);

    if (count($files) > 1)
    {
        foreach ($files as $file)
        {
            // skip files that don't represent migration data
            if (trim(strtolower($file)) !== 'migrate.php' && $file !== '.' && $file !== '..')
            {
                require_once $file;
            }
        }
    }
}

?>