<?php
namespace T4webFormRenderer;

use Zend\View\Model\ViewModel;

class Element extends ViewModel
{
    /**
     * @var array Validation error messages
     */
    protected $messages = [];

    /**
     * Data being validated
     *
     * @var mixed
     */
    protected $data;

    /**
     * @param array $variables
     * @param array $options
     * @param string $template
     */
    public function __construct($variables = null, $options = null, $template = null)
    {
        parent::__construct($variables, $options);

        // May be overloaded by inheriting class
        if (empty($this->template)) {
            $this->template = $template;
        }
    }

    /**
     * Set a hash of element names/messages to use when validation fails
     *
     * @param  array $messages
     * @return Element
     * @throws Exception\InvalidArgumentException
     */
    public function setMessages(array $messages)
    {
        $children = $this->getVariable('children');

        foreach ($messages as $key => $message) {
            if (is_int($key) && is_string($message)) {
                $this->messages[] = $message;
            }
        }

        if (empty($children)) {
            return $this;
        }

        foreach ($messages as $key => $messageSet) {
            if (is_int($key) && is_string($messageSet)) {
                continue;
            }

            if (!isset($children[$key])) {
                continue;
            }

            $children[$key]->setMessages($messageSet);
        }

        return $this;
    }

    /**
     * Returns a list of validation failure messages, if any.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Returns has validation failure messages.
     *
     * @return bool
     */
    public function hasMessages()
    {
        return !empty($this->messages);
    }

    /**
     * Set data to validate and/or populate elements
     *
     * Typically, also passes data on to the composed input filter.
     *
     * @param  mixed $data
     * @return Element
     */
    public function setData($data)
    {
        if (!is_array($data)) {
            $this->data = $data;
            return $this;
        }

        $children = $this->getVariable('children');

        if (empty($children)) {
            return $this;
        }

        foreach ($data as $key => $value) {
            if (!isset($children[$key])) {
                continue;
            }

            $children[$key]->setData($value);
        }

        return $this;
    }

    /**
     * Retrieve the validated data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}