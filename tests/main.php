<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Programster\DockerCompose\Port;
use \Programster\DockerCompose\Volume;
use \Programster\DockerCompose\PortCollection;
use Programster\DockerCompose\EnvironmentVariableCollection;
use Programster\DockerCompose\EnvironmentVariable;
use Programster\DockerCompose\Service;
use \Programster\DockerCompose\RestartEnum;
use \Programster\DockerCompose\VolumeCollection;
use \Programster\DockerCompose\DockerCompose;

$hydraPortCollection = new PortCollection(
    new Port(4444, 4444),
    new Port(4445,4445),
    new Port(5555,5555),
);

$hydraDataVolume = Volume::createBindVolume(
    $hostPath = "./hydra",
    $containerPath = "/etc/config/hydra"
);

$environment = new EnvironmentVariableCollection(
    new EnvironmentVariable("DSN", "postgres://hydra:bob@sally:5432/hydra?sslmode=disable&max_conns=20&max_idle_conns=4")
);


$hydraService = new Service(
    name: "hydra",
    image: "oryd/hydra:v1.10.3",
    containerName: "hydra",
    ports: $hydraPortCollection,
    restart: RestartEnum::createUnlessStopped(),
    volumes: new VolumeCollection($hydraDataVolume),
    environmentVariables: $environment,
    command: 'serve -c /etc/config/hydra/hydra.yml all --dangerous-force-http'
);

$config = new DockerCompose("3.8", $hydraService);
print $config;

/*
$hydraService = array(
    "image" => "oryd/hydra:v1.10.3",
    "container_name" => "hydra",
    "restart" => "unless-stopped",
    "depends_on" => array("hydra-migrate"),
    "ports" => array(
        "4444:4444",
        "4445:4445",
        "5555:5555",
    ),
    "volumes" => array(
        array(
            "type" => "bind",
            "source" => './hydra',
            "target" => "/etc/config/hydra",
        ),
    ),
    "environment" => array(
        "DSN=postgres://hydra:bob@sally:5432/hydra?sslmode=disable&max_conns=20&max_idle_conns=4"
    ),
    "command" => 'serve -c /etc/config/hydra/hydra.yml all --dangerous-force-http'
);
 *
 */