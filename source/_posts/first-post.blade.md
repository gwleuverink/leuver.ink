---
extends: _layouts.blog
section: article

title: My First Blog Post
date: 2021-07-21
excerpt: Lorem ipsum dolor sit amet. Hare ichtum vendi vide vasitum
---

# {{ $page->title }}
## {{ date('F j, Y', $page->date) }}

Lorem ipsum dolor sit amet.
