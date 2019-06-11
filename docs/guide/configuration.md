# Configuration Options

## Global Options and Default Configuration

*   `defaultFill` string `currentColor`. Color of the icon. Set to empty string to disable this attribute

*   `defaultStyle` string `solid`. See [Font Awesome](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use) – Usable for Font Awesome Pro

*   `fallbackIcon` string `@vendor/fortawesome/font-awesome/svgs/solid/question-circle.svg`. Backup icon in case requested icon cannot be found

*   `fontAwesomeFolder` string `@vendor/fortawesome/font-awesome/svgs`. Path to your Font Awesome installation – Usable for Font Awesome Pro

*   `prefix` string `svg-inline--fa`. CSS class basename, requires custom CSS if changed

### Input Group Specific Global Options

*   `defaultAppend` bool `false`. Set to `true` to append

*   `defaultGroupSize` string `md`. Set to `sm` for small or `lg` for large

## Individual Icon Options

*   `name` string. Name of the icon, picked from [Icons](https://fontawesome.com/icons)

*   `style` string. Style of the icon, must match `name`

*   `class` string. Additional custom classes.

*   `fill` string. Color of the icon

*   `height` int. The height of the icon. This will override height and width classes.

*   `prefix` string. CSS class name, requires custom CSS if changed

*   `title` string. Sets a title to the SVG output

### Input Group Specific Individiual Options

*   `append` bool `false`.  Set to `true` to append

*   `fixedWidth` bool `true`. Set to `false` to have variable width icons

*   `groupSize` string `md`. Set to `sm` for small or `lg` for large
