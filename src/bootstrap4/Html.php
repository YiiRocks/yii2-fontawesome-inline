<?php

namespace thoulah\fontawesome\bootstrap4;

/**
 * {@inheritdoc}
 */
class Html extends \yii\bootstrap4\Html
{
    /**
     * Returns the ActiveField inputTemplate.
     *
     * @param string|null $groupSize Size of the `input-group`
     * @param bool|null   $append    Whether to prepend or append the `input-group`
     *
     * @return string
     */
    public static function activeFieldAddon(?string $groupSize, ?bool $append): string
    {
        $inputGroupClass = ['input-group'];
        if (null !== $groupSize && 'md' !== $groupSize) {
            static::addCssClass($inputGroupClass, "input-group-{$groupSize}");
        }

        return static::tag('div', ($append) ? '{input}{icon}' : '{icon}{input}', ['class' => $inputGroupClass]);
    }

    /**
     * Returns the ActiveField Icon.
     *
     * @param bool|null $append Whether to prepend or append the `input-group`
     *
     * @return
     */
    public static function activeFieldIcon(?bool $append): string
    {
        $direction = ($append) ? 'append' : 'prepend';
        $icon = static::tag('div', '{icon}', ['class' => 'input-group-text']);

        return static::tag('div', $icon, ['class' => "input-group-{$direction}"]);
    }
}
