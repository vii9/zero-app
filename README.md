## About Laravel

Description

- [goto link](https://demolink.dev)

###  queues, emails, notifications
```
#refresh database
$ >   php artisan migrate:fresh [--seed]

# setup sent gmail
# https://stackoverflow.com/questions/42558903/expected-response-code-250-but-got-code-535-with-message-535-5-7-8-username
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=yourEmail@gmail.com
MAIL_PASSWORD=yourPasswordEmail
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=yourEmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
PHP_FPM_INSTALL_EXIF=true
#End Mail Config

# // Queue
    $   php artisan queue:work --tries=3 --stop-when-empty
# // Task Schedule
    $   php artisan schedule:work
```
