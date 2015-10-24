<?php namespace Propaganistas\EmailObfuscator\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

class Extension extends Twig_Extension
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'propaganistas.emailObfuscator';
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter(
                'obfuscateEmail',
                array($this, 'parse'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Twig filter callback.
     *
     * @return string Filtered content
     */
    public function parse($content)
    {
        return obfuscateEmail($content);
    }

}