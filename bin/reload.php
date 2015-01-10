<?php


require __DIR__ . '/base_script.php';
show_run("Drop DB", "app/console doctrine:database:drop --force");
show_run("Create DB", "app/console doctrine:database:create");
show_run("Create scheme", "app/console doctrine:schema:create");
show_run("Install assets", "app/console assets:install --symlink");
show_run("Load fixtures", "app/console doctrine:fixtures:load --no-interaction");