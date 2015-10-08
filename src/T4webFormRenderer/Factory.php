<?php
namespace T4webFormRenderer;

use Zend\View\Model\ViewModel;

class Factory {

    /**
     * @param array $config
     *
     * @return Element
     */
    public function create(array $config)
    {
        if (!isset($config['type'])) {
            throw new Exception\InvalidArgumentException('Config expects key "type", none given');
        }

        $elementClass = $config['type'];

        if (!class_exists($elementClass)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Type "%s" not exists',
                $elementClass
            ));
        }

        if (!isset($config['variables']) || !is_array($config['variables'])) {
            $config['variables'] = [];
        }

        /** @var Element $element */
        $element = new $elementClass($config['variables']);

        $children = [];
        if (isset($config['children'])) {
            foreach ($config['children'] as $name=>$childConfig) {
                /** @var Element $child */
                $child = $this->create($childConfig);
                $child->setVariable('name', $name);
                $children[] = $child;
            }
        }

        $element->setVariable('children', $children);

        return $element;
    }

}