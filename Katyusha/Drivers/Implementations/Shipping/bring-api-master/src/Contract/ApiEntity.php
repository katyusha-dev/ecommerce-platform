<?php

namespace Trafficfox\Bring\API\Contract;

use SimpleXMLElement;

/**
 * Class ApiEntity.
 */
abstract class ApiEntity
{
    /**
     * Can be modified with the respective data functions.
     *
     * @var array Data for the entity.
     */
    protected array $_data = [];

    /**
     * Validates this entity. Throws exception if errors.
     *
     * @throws \Trafficfox\Bring\API\Contract\ContractValidationException
     */
    abstract public function validate(): mixed;

    /**
     * @return array serialized entity
     */
    public function toArray(): array
    {
        $this->validate();

        return $this->dataToArray($this->_data);
    }

    public function toXml($rootElement = 'root')
    {
        $xml = new SimpleXMLElement('<'.$rootElement.'/>');
        $result = $this->toArray();
        $this->recursiveXml($xml, $result);

        return $xml->asXML();
    }

    /**
     * Sets data by key and value.
     *
     * @param $key Identifier
     * @param $value The value
     *
     * @return $this
     */
    protected function setData($key, $value)
    {
        $this->_data[$key] = $value;

        return $this;
    }

    /**
     * Gets data based on key.
     *
     * @param $key The identifier.
     */
    protected function getData($key): mixed
    {
        return $this->_data[$key];
    }

    protected function removeData($key)
    {
        if (isset($this->_data[$key])) {
            unset($this->_data[$key]);
        }

        return $this;
    }

    /**
     * Adds data to data array.
     *
     * @param $key Identifier.
     * @param $value Value to add
     *
     * @return $this
     */
    protected function addData($key, $value)
    {
        if (! isset($this->_data[$key]) || ! is_array($this->_data[$key])) {
            $this->_data[$key] = [];
        }
        $this->_data[$key][] = $value;

        return $this;
    }

    /**
     * Checks if data contains given identifier.
     *
     * @param $key
     */
    protected function containsData($key): bool
    {
        return isset($this->_data[$key]);
    }

    /**
     * Recursively serialize data and ApiEntity instances.
     *
     * @param array $data Array of data
     *
     * @return array Serialized array
     */
    protected function dataToArray(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if ($value instanceof self) {
                $result[$key] = $value->toArray();
            } elseif (is_array($value)) {
                $result[$key] = $this->dataToArray($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    private function recursiveXml(SimpleXMLElement $object, array $data): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $object->addChild($key);
                $this->recursiveXml($new_object, $value);
            } else {
                $object->addChild($key, $value);
            }
        }
    }
}
