<?php
/**
 * This file is part of the Rhumsaa\Sculpin\CodeBlock bundle for Sculpin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Rhumsaa\Sculpin\Bundle\CodeBlockBundle;

use Sculpin\Bundle\MarkdownBundle\SculpinMarkdownBundle;
use Sculpin\Bundle\TwigBundle\SculpinTwigBundle;
use Sculpin\Core\Event\ConvertEvent;
use Sculpin\Core\Sculpin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Converts Twig {% codeblock %} tags to HTML <div> tags to avoid Markdown
 * collisions; then converts them back to {% codeblock %} tags for Twig to
 * process
 */
class ConvertListener implements EventSubscriberInterface
{
    /**
     * List of regular expressions needing placeholders
     *
     * @var array
     */
    protected static $addPlaceholderRe = array(
        '/^({%\s+codeblock\s+(.+?)\s*%})$/Um',
        '/^({%\s+endcodeblock\s+%})$/m',
    );

    /**
     * Placeholder text
     *
     * @var string
     */
    protected static $placeholder = "\n<div><!-- sculpin-hidden -->$1<!-- /sculpin-hidden --></div>\n";

    /**
     * Regex used to remove placeholder
     *
     * @var string
     */
    protected static $removePlaceholderRe = "/(\n?<div><!-- sculpin-hidden -->|<!-- \/sculpin-hidden --><\/div>\n|\n?&lt;div&gt;&lt;!-- sculpin-hidden --&gt;|&lt;!-- \/sculpin-hidden --&gt;&lt;\/div&gt;\n)/m";

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Sculpin::EVENT_BEFORE_CONVERT => 'beforeConvert',
            Sculpin::EVENT_AFTER_CONVERT => 'afterConvert',
        );
    }

    /**
     * Called before conversion
     *
     * @param ConvertEvent $convertEvent Convert Event
     */
    public function beforeConvert(ConvertEvent $convertEvent)
    {
        if ($convertEvent->isHandledBy(SculpinMarkdownBundle::CONVERTER_NAME, SculpinTwigBundle::FORMATTER_NAME)) {
            $content = $convertEvent->source()->content();
            foreach (self::$addPlaceholderRe as $re) {
                $content = preg_replace($re, self::$placeholder, $content);
            }
            $content = preg_replace('/{%\s+codeblock\s+(.+?)\s*%}(.*){%\s+endcodeblock\s+%}/Us', '<div data-codeblock-args="$1">$2</div>', $content);
            $convertEvent->source()->setContent($content);
        }
    }

    /**
     * Called after conversion
     *
     * @param ConvertEvent $convertEvent Convert event
     */
    public function afterConvert(ConvertEvent $convertEvent)
    {
        if ($convertEvent->isHandledBy(SculpinMarkdownBundle::CONVERTER_NAME, SculpinTwigBundle::FORMATTER_NAME)) {
            $content = $convertEvent->source()->content();
            $content = preg_replace(self::$removePlaceholderRe, '', $content);
            $content = preg_replace('/<div data-codeblock-args="(.*?)">(.*?)<\/div>/Us', '{% codeblock $1 %}$2{% endcodeblock %}', $content);
            $convertEvent->source()->setContent($content);
        }
    }
}
