<?php

/*
 * This will create two nginx services that share a named volume.
 * Thus, if you enter one of the containers, and change the content within /usr/share/nginx/html,
 * you will see the change in the other container as well, and the site will change on both ports.
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use \Programster\DockerCompose\Port;
use \Programster\DockerCompose\Volume;
use \Programster\DockerCompose\PortCollection;
use \Programster\DockerCompose\EnvironmentVariableCollection;
use \Programster\DockerCompose\EnvironmentVariable;
use \Programster\DockerCompose\Service;
use \Programster\DockerCompose\RestartEnum;
use \Programster\DockerCompose\VolumeCollection;
use \Programster\DockerCompose\DockerCompose;

$namedVolumeConfig = new \Programster\DockerCompose\NamedVolumeConfig("shared-volume");


$service1 = new Service(
    name: "service1",
    image: "nginx",
    containerName: "box1",
    ports: new PortCollection(new Port(80, 80)),
    restart: RestartEnum::createNo(),
    volumes: new VolumeCollection(Volume::createNamedVolume($namedVolumeConfig, "/usr/share/nginx/html")),
);

$service2 = new Service(
    name: "service2",
    image: "nginx",
    containerName: "box2",
    ports: new PortCollection(new Port(80, 8000)),
    restart: RestartEnum::createNo(),
    volumes: new VolumeCollection(Volume::createNamedVolume($namedVolumeConfig, "/usr/share/nginx/html")),
);

$config = new DockerCompose("3.9", $service1, $service2);
print $config;
