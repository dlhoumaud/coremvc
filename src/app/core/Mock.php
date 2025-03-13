<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2025-03-13 00:40:31
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-13 01:02:36
 * @ Description: Permet de tester les fonctionnalités de l'application
 */

namespace App\Core;

use Exception;

class Mock
{
    protected static function createMock(string $className, array $methods = [])
    {
        if (!class_exists($className) && !interface_exists($className)) {
            throw new Exception("La classe ou l'interface $className n'existe pas.");
        }

        return new class(new $className(), $methods) {
            private object $originalInstance;
            public array $mockedMethods = [];

            public function __construct(object $instance, array $methods)
            {
                $this->originalInstance = $instance;
                foreach ($methods as $method => $returnValue) {
                    $this->method($method)->willReturn($returnValue);
                }
            }

            public function method(string $methodName)
            {
                return new class($this, $methodName) {
                    private object $mockInstance;
                    private string $methodName;

                    public function __construct($mockInstance, string $methodName)
                    {
                        $this->mockInstance = $mockInstance;
                        $this->methodName = $methodName;
                    }

                    public function willReturn($value)
                    {
                        $this->mockInstance->mockedMethods[$this->methodName] = fn() => $value;
                    }
                };
            }

            public function __call($name, $arguments)
            {
                if (isset($this->mockedMethods[$name])) {
                    return call_user_func_array($this->mockedMethods[$name], $arguments);
                }

                // Si la méthode n'est pas mockée, on appelle la méthode réelle
                if (method_exists($this->originalInstance, $name)) {
                    return call_user_func_array([$this->originalInstance, $name], $arguments);
                }

                throw new Exception("Méthode '$name' introuvable dans le mock.");
            }
        };
    }

    public function setUp(): void
    {
        // Cette méthode est exécutée avant chaque test
        // Initialisation des mocks ou autres configurations ici
        // Exemple :
        // $this->mock = self::createMock(MyClass::class);
        // $this->mock->method('myMethod')->willReturn('mockedValue');
    }

    public function tearDown(): void
    {
        // Cette méthode est exécutée après chaque test
        // Nettoyage ou désinitialisation ici
        // Exemple :
        // $this->mock = null;
        // unset($this->mock);
    }
}