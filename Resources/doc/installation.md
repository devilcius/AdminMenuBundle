devilciusAdminMenuBundle installation steps
====================================

1) Installing the bundle
------------------------

Use composer to install this bundle (using the master version)
```
php composer.phar require devilcius/admin-menu-bundle
```

2) Register the bundle
----------------------

In app/appKernel.php add the following line to register the bundle:
```php
[...]
            new devilcius\AdminMenuBundle\devilciusAdminMenuBundle(),
[...]
```

If you have already a bundle that extends the SonataAdminBundle, you must change its parent to devilciusAdminMenuBundle.


