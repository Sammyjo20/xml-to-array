<?php

namespace Sammyjo20\XmlToArray;

use DOMText;
use DOMElement;
use DOMDocument;
use DOMCdataSection;
use DOMNamedNodeMap;

class XmlToArray
{
    /**
     * @var DOMDocument
     */
    protected DOMDocument $document;

    /**
     * @param string $xml
     */
    public function __construct(string $xml)
    {
        $this->document = new DOMDocument();
        $this->document->loadXML($xml);
    }

    /**
     * Convert XML into an array
     *
     * @param string $xml
     * @return array
     */
    public static function convert(string $xml): array
    {
        return (new static($xml))->toArray();
    }

    /**
     * Convert the XML to an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        if ($this->document->hasChildNodes()) {
            $children = $this->document->childNodes;

            foreach ($children as $child) {
                $result[$child->nodeName] = $this->convertDomElement($child);
            }
        }

        return $result;
    }

    /**
     * @param DOMElement $element
     * @return array|string|null
     */
    protected function convertDomElement(DOMElement $element): array|string|null
    {
        $result = $this->convertAttributes($element->attributes);

        $sameNamesOccurrences = [];

        if ($element->childNodes->length > 1) {
            $childNodeNames = [];

            foreach ($element->childNodes as $node) {
                $childNodeNames[] = $node->nodeName;
            }

            $sameNamesOccurrences = array_count_values($childNodeNames);
        }

        foreach ($element->childNodes as $node) {
            if ($node instanceof DOMCdataSection) {
                $result['_cdata'] = $node->data;

                continue;
            }

            if ($node instanceof DOMText) {
                $result = $node->textContent;

                continue;
            }

            if ($node instanceof DOMElement) {
                $nodeName = $node->nodeName;
                $hasSameName = array_key_exists($nodeName, $sameNamesOccurrences) && $sameNamesOccurrences[$nodeName] > 1;

                if ($hasSameName === false) {
                    $result[$nodeName] = $this->convertDomElement($node);
                    continue;
                }

                $result[$nodeName][] = $this->convertDomElement($node);
            }
        }

        return $result;
    }

    /**
     * @param DOMNamedNodeMap $nodeMap
     * @return array
     */
    protected function convertAttributes(DOMNamedNodeMap $nodeMap): array
    {
        if ($nodeMap->length === 0) {
            return [];
        }

        $result = [];

        foreach ($nodeMap as $item) {
            $result[$item->name] = $item->value;
        }

        return ['_attributes' => $result];
    }
}
