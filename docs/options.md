# Options

## Icon Options

*   `name` string. Name of the icon, picked from [Icons](https://fontawesome.com/icons),
    or a valid path to a custom file.

*   `style` string. Style of the icon, must match `name`.

*   `class` string. Additional custom classes.

*   `addClass` bool. Whether or not to add calculated classes to custom files.

*   `css` array. Additional CSS attributes.

*   `fill` string. Color of the icon.

*   `fixedWidth` bool. Set to `true` to have a fixed width icon.

*   `height` int. The height of the icon. This will dismiss the automatic height
    and width classes. If `height` is given without `width`, the latter
    will be calculated from the SVG size.

*   `id` string. Id for the SVG tag.

*   `prefix` string. CSS class name, requires custom CSS if changed.

*   `title` string. Sets a title to the SVG output.

*   `width` int. The width of the icon. This will dismiss the automatic height
    and width classes. If `width` is given without `height`, the latter
    will be calculated from the SVG size.

### ActiveForm Specific Options

*   `append` bool. Whether to prepend or append the `input-group`. This will
    change both tag order and applied class.

*   `fixedWidth` bool. Set to `false` to have variable width icons.

*   `groupSize` string. Set to `sm` for small or `lg` for large. Defaults to
    `md` or medium.
