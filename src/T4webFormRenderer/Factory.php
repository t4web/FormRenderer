<?php
namespace T4webFormRenderer;

use Zend\View\Model\ViewModel;

class Factory {

    /**
     * @param array $config
     *
     * @return Element
     */
    public function create(array $config, $name='')
    {
        if (!isset($config['type'])) {
            $config['type'] = 'T4webFormRenderer\Element';
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

        $template = null;
        if (isset($config['template'])) {
            $template = $config['template'];
        }

        /** @var Element $element */
        $element = new $elementClass($config['variables'], [], $template);

        if ($element->getTemplate() == '') {
            throw new Exception\InvalidArgumentException(sprintf(
                'Element "%s" must be configured with template',
                $name
            ));
        }

        $children = [];
        if (isset($config['children'])) {
            foreach ($config['children'] as $name=>$childConfig) {
                /** @var Element $child */
                $child = $this->create($childConfig, $name);
                $child->setVariable('name', $name);
                $children[$name] = $child;
            }
        }

        $element->setVariable('children', $children);

        return $element;
    }

}