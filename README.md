[![License: GPL
v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

# CAS Authentication Module for Omeka S

## Installation

### From the zip file

Download the zip file of the [most recent
commit](https://github.com/StAResComp/omeka-s-module-cas/archive/refs/heads/main.zip)
and unzip it into the `modules` folder.

### From source

```
cd /path/to/omeka-s/modules
git clone https://github.com/starescomp/omeka-s-module-cas.git Cas
cd Cas
composer install --no-dev
```

## Configuration

CAS configuration should be done in Omeka S main configuration file
(`config/local.config.php`)

Example:

```php
<?php
return [
    'cas' => [
        'adapter_options' => [
            'cas_server' => 'https://your.cas.server',
            'cas_service' => 'https://your.omeka.site/cas-login',
            'cas_email_domain' => 'your.email.domain',
        ],
    ],
];
```

## Usage

This module will authenticate existing users via CAS; it will not, currently,
create new users. This means that user accounts need to be created by an
existing user.

Upon successful login, the user is directed to the `admin` route; on failure
they are sent to the site homepage.

## Development

Development drew heavily on the [Ldap module for Omeka
S](https://github.com/biblibre/omeka-s-module-Ldap) and on the source code for
[Omeka S](https://github.com/omeka/omeka-s/) itself.

## License

This module is published under the GNU General Public License (version 3 or
later).
