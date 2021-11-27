---
extends: _layouts.blog
section: article

title: My First Blog Post
date: 2021-07-21
readTime: 3 minute read
---

Lorem ipsum dolor sit amet.

Code example with Torchlight:

``` php
// PHP
return [
    'extensions' => [
        // Add attributes straight from markdown.
        AttributesExtension::class,

        // Add Torchlight syntax highlighting.
        TorchlightExtension::class,
    ]
]
```

``` JavaScript
// JavaScript
const btn = document.getElementById('btn')
let count = 0

function render() {
    btn.innerText = `Count: ${count}`
}

btn.addEventListener('click', () => {
    // Count from 1 to 10.
    if (count < 10) {

        count += 1
        render()
    }
})
```
