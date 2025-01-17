<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\ServiceGovernance\Register;

use Hyperf\Consul\Agent;
use Hyperf\Guzzle\ClientFactory;
use Psr\Container\ContainerInterface;

class ConsulAgentFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Agent(function () use ($container) {
            $options = [
                'timeout' => 2,
            ];
            return $container->get(ClientFactory::class)->create($options);
        });
    }
}
