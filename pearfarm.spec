<?php

$spec = Pearfarm_PackageSpec::create(array(Pearfarm_PackageSpec::OPT_BASEDIR => dirname(__FILE__)))
             ->setName('PGraph')
             ->setChannel('http://pear.php.net/package/pgraph')
             ->setSummary('A PHP Graph data structure creating and manipulating library/')
             ->setDescription('Use this library to create your graph data structures and manipulate them any way you want. As new versions come out, more functionality will be added.')
             ->setReleaseVersion('1.0')
             ->setReleaseStability('stable')
             ->setApiVersion('1.0')
             ->setApiStability('stable')
             ->setLicense(Pearfarm_PackageSpec::LICENSE_MIT)
             ->setNotes('Initial release.')
             ->addMaintainer('lead', 'Vilius Zaikauskas', 'willux89', 'zaikaus1@gmail.com')
             ->addGitFiles()
             ->addExecutable('src/PGraph.php')
             ;
