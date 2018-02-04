<?php/*

namespace Blueprint\Acf\Group;
use \Blueprint\Acf as acf;
use \Blueprint\Acf\Field as field;

class PostMedia extends acf\Group {

  protected $formats;
  protected $mediaFormatKey;
  protected $videoSourceKey;

  function __construct($name=null,$parent=null) {
    if ($name == 'post') {$name = '';}
    else {$name = $name . '_';}
    $name = $name . 'post_media';
    parent::__construct($name,$parent=null);
    $this->setLabelPlacement('left');
    $this->setName($name);
    $this->setTitle('Media');
    $this
      ->setFormats()
      ->setPosition('high');
  }

  static function getDefaultFormats() {
    return array(
      'image',
      'video'
    );
  }

  // Set default fields

  protected function setDefaultFields() {
    foreach ($this->formats as $format) {
      if (in_array($format,self::getDefaultFormats())) {
        $method = 'set' . ucwords($format) . 'Field';
        $this->$method();
      }
    }
  }

  // Default Field Setters

  protected function setImageField() {
    $this->addTip('You can set the Featured Image over on the right.',true)
      ->setLogic($this)
        ->addCondition($this->mediaFormatKey,'image');
  }

  protected function setVideoField() {
    $name = $this->getPostType() . '_media_featured_image_tip';
    // Video
    $video_source_name = $this->getPostType() . '_video_source';
    // Video Source
    $video_source = $this->addSelect($video_source_name,$this)
      ->setChoices(array(
        'youtube' => 'YouTube',
        'vimeo' => 'vimeo'
      ))
      ->setLabel('Video Source')
      ->setLogic()
        ->addCondition($this->mediaFormatKey,'video')
        ->end();
    // Vimeo
    $vimeo = $this->addText($this->prefix('vimeo_video_id'),$this)
      ->setLabel('Link')
      ->setPrepend('vimeo.com/')
      ->setPlaceholder('227138298')
      ->setLogic()
        ->addCondition($video_source->getKey(),'vimeo')
        ->andCondition($this->mediaFormatKey,'video');
    // YouTube
    $youtube = $this->addText($this->prefix('youtube_video_id'),$this)
      ->setLabel('Link')
      ->setPrepend('youtube.com/watch?v=')
      ->setPlaceholder('T-YqcuatM6I')
      ->setLogic()
        ->addCondition($video_source->getKey(),'youtube')
        ->andCondition($this->mediaFormatKey,'video');
  }

  protected function prefix($name) {
    return $this->getPostType() . '_' . $name;
  }

  protected function getPostType() {
    return str_replace('_post_media','',$this->name);
  }

  protected function preRegister() {
    $this->mediaFormatKey = 'field_' . $this->getPostType() . '_media_format';
    $name = str_replace('_post_media','',$this->name);
    $select = (new field\Choice($this->prefix('media_format'),$this))
      ->setLabel('Media Format')
      ->setChoices($this->formats)
      ->setInstructions('The primary media to be displayed.');
    $this->addField($select);
    $this->setDefaultFields();
  }

  function setFormats($formats=null) {
    if (!$formats) {$formats = $this::getDefaultFormats();}
    if (is_string($formats)) {$formats = array($formats);}
    $this->formats = $formats;
    return $this;
  }

}
