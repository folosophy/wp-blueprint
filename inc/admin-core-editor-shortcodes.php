<?php

namespace Blueprint {

  $button = new EditorMediaButton('Add Media');

  bp_require('inc/action-editor-shortcodes',BP);
  bp_require('inc/action-editor-shortcodes-modal',BP);

  // $admin_style = (new Enqueue\Style('bp_admin_style','assets/css/admin.css',BP))
  //   ->setAction('admin_enqueue_scripts');
  //
  // $editor_script = (new Enqueue\Script('bp_editor_shortcodes','assets/js/media-uploader.js',BP))
  //   ->addAction('admin_enqueue_scripts');

  //$localize_editor_script = (new LocalizeScript('bp_editor_shortcodes',BP));

  class ShortcodeForm {

    protected $fields;
    protected $type;
    protected $name;

    function __construct($type) {
      $this->type = $type;
      $this->setName();
      $method = 'build' . $this->name;
      $this->$method();
    }

    protected function setName() {
      $this->name = ucwords($this->type);
    }

    protected function buildImage() {
      $sizes = Part\Image::getSizes();
      $size_options = '<option selected disabled>Select a size</option>';
      foreach ($sizes as $size => $info) {
        $label = $info['label'];
        $size_options .= "<option value='$size'>$label</option>";
      }
      $select_size = "
        <select class='field' name='size'>
          $size_options
        </select>
      ";
      $this->fields .= "
        <p><img style='display:block' width='50px' height='50px' /></p>
        <p><div class='button bp-image--select'>Select an image</div></p>
        <p>$select_size</p>
        <p><input class='field' disabled hidden type='number' name='img_id' placeholder='Click to choose image' /></p>
      ";
    }

    function build() {
      return "
        <h2>$this->name</h2>
        <form class='bp-shortcode-options' shortcode-type='$this->type'>
          $this->fields
          <p>
            <div class='button-primary create-editor-shortcode' type='submit'>Create</div>
          </p>
        </form>
      ";
    }

    function render() {
      echo $this->build();
    }

  }

}

namespace {



  function bp_editor_options() {
    $type = $_POST['type'];
    $form = (new Blueprint\ShortcodeForm($type))
      ->render();
    wp_die();
  } add_action('wp_ajax_bp_editor_options','bp_editor_options');

}
