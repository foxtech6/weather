# Install
- composer install
- copy `parameters.yml.dist` to `parameters.yml` and put your parameters
- put to crontab `*/10 * * * * cd /path-to-project && php run.php >> /dev/null 2>&1`