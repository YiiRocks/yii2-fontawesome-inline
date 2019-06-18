# Configuration

## Global Options and Default Configuration

*   `defaultFill` string `currentColor`. Color of the icon. Set to empty string to disable this attribute

*   `defaultFixedWidth` bool `false`. Set to `true` to have fixed width icons

*   `defaultStyle` string `solid`. See [Font Awesome](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use) – Usable for Font Awesome Pro

*   `fallbackIcon` string `@vendor/fortawesome/font-awesome/svgs/solid/question-circle.svg`. Backup icon in case requested icon cannot be found

*   `fontAwesomeFolder` string `@vendor/fortawesome/font-awesome/svgs`. Path to your Font Awesome installation – Usable for Font Awesome Pro

*   `prefix` string `svg-inline--fa`. CSS class basename, requires custom CSS if changed

### ActiveForm Specific Global Options and Default Configuration

*   `defaultAFFixedWidth` bool `true`. Set to `false` to have variable width icons. Overrules `defaultFixedWidth`

*   `defaultAppend` bool `false`. Whether to prepend or append the `input-group`

*   `defaultGroupSize` string `md`. Set to `sm` for small or `lg` for large
