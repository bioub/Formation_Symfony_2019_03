<?php

namespace Finindev\BootstrapBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BootstrapExtension extends AbstractExtension
{
    /** @var \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface */
    protected $flashBag;

    /**
     * BootstrapExtension constructor.
     * @param \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface $flashBag
     */
    public function __construct(\Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bootstrapAlert', [$this, 'bootstrapAlert'], ['is_safe' => ['html']]),
            new TwigFunction('bootstrapFlashAlert', [$this, 'bootstrapFlashAlert'], ['is_safe' => ['html']]),
        ];
    }

    public function bootstrapAlert($msg, $type = 'success')
    {
       return "<div class=\"alert alert-$type\">$msg</div>";
    }

    public function bootstrapFlashAlert($type = 'success')
    {
        $html = '';

        foreach ($this->flashBag->get($type) as $msg) {
            $html .= $this->bootstrapAlert($msg, $type);
        }

        return $html;
    }
}
