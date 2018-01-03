<?php

namespace Blueprint\Part\Card;
use Blueprint as bp;
use \Blueprint\Part as part;

class Event extends part\Card {

  function setSubHeadline($headline=null) {
    $start = get_field('event_start');
    $start = date('F j, Y',strtotime($start));
    $headline = $start;
    return parent::setSubHeadline($headline);
  }

}
