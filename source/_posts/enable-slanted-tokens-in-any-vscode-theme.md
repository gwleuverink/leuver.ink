---
extends: _layouts.blog
section: article
tags: [vscode]
published: true

title: Enable slanted tokens in any VSCode theme
date: 2024-07-17
readTime: 5 minute read
description: If you've invested in a specialized coding font, you shouldn't be limited to a handful of compatible themes. The good news? You don't have to be. Let's explore how to enable slanted tokens in any VSCode theme!
image: assets/images/slanted-mono-font.jpg
---

I absolutely adore the alternative slanted letters in fonts like [Mono Lisa](https://www.monolisa.dev/), [Dank Mono](https://philpl.gumroad.com/l/dank-mono) and [Operator Mono](https://www.typography.com/fonts/operator/overview) (though I don't own that last one). These fonts add a touch of elegance to your code, making certain elements stand out and improving overall readability.

However, not every VSCode theme supports these stylish slanted tokens out of the box. While some themes like the popular Night Owl come with built-in support, many don't. If you've invested in a specialized coding font, you shouldn't be limited to a handful of compatible themes. The good news? You don't have to be.

Let's explore how to enable slanted tokens in any VSCode theme, using Mono Lisa as our example font and the beautiful [Midnight City](https://marketplace.visualstudio.com/items?itemName=dillonchanis.midnight-city) theme (which doesn't include an _italics_ variant).

<img class="mx-auto mt-4 mb-5 sm:max-w-lg rounded-xl drop-shadow-2xl" src="/assets/images/slanted-mono-font.jpg" alt="Mono Lisa with slanted tokens enabled">

### Setting Up Your Font

First, ensure you've installed Mono Lisa on your system. Then, open your VSCode `settings.json` file and add the following configuration:

```json
/*
|--------------------------------------------------------------------------
| Typography
|--------------------------------------------------------------------------
*/
"editor.fontFamily": "MonoLisa",
"terminal.integrated.fontFamily": "MonoLisa",
"editor.fontLigatures": "'calt' on, 'liga' on, 'zero' off, 'ss02' on, 'ss03' on, 'ss06' on, 'ss08' on, 'ss11' on",
"editor.fontVariations": true,
```

The ligature settings are optional and reflect my personal configuration from the online Mono Lisa configurator. Feel free to adjust these to your preference.

### Enabling Slanted Tokens

Now for the exciting part: overriding your theme's TextMate rules to apply italics to specific tokens. Add this section to your `settings.json` file:

Note: The scopes are collapsed by default. Click the **...** dots to see everything or check out [the gist](https://gist.github.com/gwleuverink/15bce0174d2eafcc55dac7e88ef1b546).

```json
/*
|--------------------------------------------------------------------------
| Optimize themes for Operator italics
|--------------------------------------------------------------------------
*/
"editor.tokenColorCustomizations": {
    "textMateRules": [
        {
            "name": "normalize font style of certain components",
            "scope": [
                "entity.name.type.namespace",
                "entity.other.inherited-class",
                "keyboard.control",
                "keyword.operator.arithmetic",
                "keyword.operator.assignment",
                "keyword.operator.bitwise",
                "keyword.operator.comparison",
                "keyword.operator.expression.in",
                "keyword.operator.increment",
                "keyword.operator.logical", // [tl! collapse:start]
                "keyword.operator.operator",
                "keyword.operator.or.regexp",
                "keyword.operator.ternary",
                "keyword.operator.type",
                "meta.property-list.css meta.property-value.css variable.other.less",
                "meta.property-list.sass variable.sass",
                "meta.property-list.scss variable.scss",
                "meta.tag.js meta.embedded.expression.js punctuation.section.embedded.begin.js",
                "meta.tag.js meta.embedded.expression.js punctuation.section.embedded.end.js",
                "punctuation.definintion.string",
                "punctuation.section.embedded.begin.js.jsx",
                "punctuation.section.embedded.end.js.jsx",
                "punctuation.section.embedded.js",
                "punctuation",
                "support.class",
                "support.other" // [tl! collapse:end]
            ],
            "settings": {
                "fontStyle": ""
            }
        },
        {
            "name": "italicsify for operator mono",
            "scope": [
                "comment support.class",
                "comment support.other",
                "comment",
                "constant.language",
                "constant.other.color.rgb-value.hex.css", // [tl! collapse:start]
                "constant.other.rgb-value.css",
                "entity.name.function.ts",
                "entity.name.function.tsx",
                "entity.name.tag.custom",
                "entity.name.tag.doctype",
                "entity.name.tag.yaml",
                "entity.name.type.ts",
                "entity.other.attribute-name",
                "italic",
                "keyword.control",
                "keyword.operator.expression.typeof",
                "keyword.operator.type.annotation",
                "keyword.other.unit",
                "language",
                "meta.export.js variable.other",
                "meta.export.ts meta.block.ts variable.other.readwrite.alias.ts",
                "meta.export.tsx meta.block.tsx variable.other.readwrite.alias.tsx",
                "meta.import.js variable.other",
                "meta.import.ts meta.block.ts variable.other.readwrite.alias.ts",
                "meta.import.tsx meta.block.tsx variable.other.readwrite.alias.tsx",
                "meta.object-literal.key",
                "meta.parameter",
                "meta.parameters",
                "meta.tag.sgml.doctype.html",
                "meta.tag.sgml.doctype",
                "meta.var.expr storage.type",
                "modifier",
                "parameter",
                "punctuation.section.embedded",
                "quote",
                "source.js.jsx keyword.control.flow.js",
                "storage.type.class",
                "storage",
                "support.constant.math",
                "support.constant.vendored.property-value.css",
                "support.function.basic_functions",
                "support.function.basic_functions",
                "support.type.primitive",
                "support.type.property-name.css",
                "support.type.property.css",
                "support.type.vendored.property-name.css",
                "this",
                "type .function",
                "type.function",
                "type.var",
                "variable.assignment.coffee",
                "variable.language",
                "variable.object.property.js",
                "variable.object.property.jsx",
                "variable.object.property.ts",
                "variable.object.property.tsx",
                "variable.other.less",
                "variable.parameter.url.sass",
                "variable.parameter.url.scss",
                "variable.parameter",
                "variable.sass",
                "variable.scss" // [tl! collapse:end]
            ],
            "settings": {
                "fontStyle": "italic"
            }
        }
    ]
},
```

### Customizing Your Setup

Want to fine-tune which tokens get the slanted treatment? VSCode recognizes a wide range of TextMate scopes. Check out the [VSCode documentation](https://code.visualstudio.com/api/language-extensions/syntax-highlight-guide#textmate-tokens-and-scopes) for more information on TextMate tokens and scopes.
To identify the scope for a specific token you want to modify, use the [scope inspector](https://code.visualstudio.com/api/language-extensions/syntax-highlight-guide#scope-inspector) in VSCode.
