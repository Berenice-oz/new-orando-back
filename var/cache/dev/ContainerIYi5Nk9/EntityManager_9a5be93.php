<?php

namespace ContainerIYi5Nk9;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder634e9 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerce7bb = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties9ac90 = [
        
    ];

    public function getConnection()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getConnection', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getMetadataFactory', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getExpressionBuilder', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'beginTransaction', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getCache', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getCache();
    }

    public function transactional($func)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'transactional', array('func' => $func), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->transactional($func);
    }

    public function commit()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'commit', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->commit();
    }

    public function rollback()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'rollback', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getClassMetadata', array('className' => $className), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'createQuery', array('dql' => $dql), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'createNamedQuery', array('name' => $name), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'createQueryBuilder', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'flush', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'clear', array('entityName' => $entityName), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->clear($entityName);
    }

    public function close()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'close', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->close();
    }

    public function persist($entity)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'persist', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'remove', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'refresh', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'detach', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'merge', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getRepository', array('entityName' => $entityName), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'contains', array('entity' => $entity), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getEventManager', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getConfiguration', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'isOpen', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getUnitOfWork', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getProxyFactory', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'initializeObject', array('obj' => $obj), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'getFilters', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'isFiltersStateClean', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'hasFilters', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return $this->valueHolder634e9->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerce7bb = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder634e9) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder634e9 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder634e9->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, '__get', ['name' => $name], $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        if (isset(self::$publicProperties9ac90[$name])) {
            return $this->valueHolder634e9->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder634e9;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder634e9;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder634e9;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder634e9;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, '__isset', array('name' => $name), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder634e9;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder634e9;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, '__unset', array('name' => $name), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder634e9;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder634e9;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, '__clone', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        $this->valueHolder634e9 = clone $this->valueHolder634e9;
    }

    public function __sleep()
    {
        $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, '__sleep', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;

        return array('valueHolder634e9');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerce7bb = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerce7bb;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerce7bb && ($this->initializerce7bb->__invoke($valueHolder634e9, $this, 'initializeProxy', array(), $this->initializerce7bb) || 1) && $this->valueHolder634e9 = $valueHolder634e9;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder634e9;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder634e9;
    }


}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
