<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$hydraPortCollection = new \Programster\DockerCompose\PortCollection(
    new Programster\DockerCompose\Port(4444, 4444),
    new Programster\DockerCompose\Port(4445,4445),
    new Programster\DockerCompose\Port(5555,5555),
);

$hydraDataVolume = \Programster\DockerCompose\Volume::createBindVolume(
    $hostPath = "./hydra",
    $containerPath = "/etc/config/hydra"
);

$environment = new Programster\DockerCompose\EnvironmentVariableCollection(
    new Programster\DockerCompose\EnvironmentVariable("DSN", "postgres://hydra:bob@sally:5432/hydra?sslmode=disable&max_conns=20&max_idle_conns=4")
);


$hydraService = new Programster\DockerCompose\Service(
    name: "hydra",
    image: "oryd/hydra:v1.10.3",
    containerName: "hydra",
    ports: $hydraPortCollection,
    restart: \Programster\DockerCompose\RestartEnum::createUnlessStopped(),
    volumes: new \Programster\DockerCompose\VolumeCollection($hydraDataVolume),
    environmentVariables: $environment,
    command: 'serve -c /etc/config/hydra/hydra.yml all --dangerous-force-http'
);

$config = new \Programster\DockerCompose\DockerCompose("3.8", $hydraService);
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