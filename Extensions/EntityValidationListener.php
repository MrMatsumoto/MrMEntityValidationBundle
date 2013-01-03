<?php

namespace MrM\MrMEntityValidationBundle\Extensions;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAware;

use MrM\MrMEntityValidationBundle\Exception\ValidationException;

class EntityValidationListener extends ContainerAware {
    
    private static $containerInstance = null;
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        parent::setContainer($container);
        self::$containerInstance = $container;
    }
    
    public static function getContainer()
    {
        return self::$containerInstance;
    }
        
    public function prePersist(LifecycleEventArgs $args) {
        $this->validateOrThrow($args->getEntity());
    }
    
    public function preUpdate(LifecycleEventArgs $args) {
        $this->validateOrThrow($args->getEntity());
    }
    
    private function validateOrThrow($entity) {
        $errors = $this->getContainer()->get('validator')->validate($entity);
        if (count($errors) != 0) {
            $errorsArray = array();
            foreach ($errors as $error)
                $errorsArray[] = $error->getPropertyPath() . ": " . $error->getMessage();
            throw new ValidationException('entity not valid ... ' . implode('; ', $errorsArray));
        }                
    }    
    
}

?>
