<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Di\Aop;

use Closure;
use Hyperf\Di\Annotation\AnnotationCollector;

class ProceedingJoinPoint
{
    /**
     * @var string
     */
    public $className;

    /**
     * @var string
     */
    public $methodName;

    /**
     * @var mixed[]
     */
    public $arguments;

    /**
     * @var mixed
     */
    public $result;

    /**
     * @var Closure
     */
    public $originalMethod;

    /**
     * @var Closure
     */
    public $pipe;

    public function __construct(Closure $originalMethod, string $className, string $methodName, array $arguments)
    {
        $this->originalMethod = $originalMethod;
        $this->className = $className;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * Delegate to the next aspect.
     */
    public function process()
    {
        $closure = $this->pipe;
        return $closure($this);
    }

    /**
     * Process the original method, this method should trigger by pipeline.
     */
    public function processOriginalMethod()
    {
        $this->pipe = null;
        $closure = $this->originalMethod;
        if (count($this->arguments['keys']) > 1) {
            $arguments = $this->getArguments();
        } else {
            $arguments = array_values($this->arguments['keys']);
        }
        return $closure(...$arguments);
    }

    public function getAnnotationMetadata(): AnnotationMetadata
    {
        $metadata = AnnotationCollector::get($this->className);
        return new AnnotationMetadata($metadata['_c'] ?? [], $metadata['_m'][$this->methodName] ?? []);
    }

    public function getArguments()
    {
        return value(function () {
            $result = [];
            foreach ($this->arguments['order'] ?? [] as $order) {
                $result[] = $this->arguments['keys'][$order];
            }
            return $result;
        });
    }
}
