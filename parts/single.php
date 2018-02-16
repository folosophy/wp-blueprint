<?php

namespace Blueprint\Part;

$single = (new Template\Single());

$content = apply_filters('the_content',get_the_content());

$article = $single->addPart('post__content');

  $article->addText($content);

$single->render();
