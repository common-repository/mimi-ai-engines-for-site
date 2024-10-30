<?php

namespace VietDevelopers\MiMi\Customizes\CustomizeControl;

use WP_Customize_Control;

class SelectImageControl extends WP_Customize_Control
{
    public $type = 'image_select';

    public function render_content()
    {
        if (empty($this->choices)) {
            return;
        }

        $name = '_customize-image-select-' . $this->id;
?>
        <span class="customize-control-title">
            <?php echo esc_html($this->label); ?>
        </span>

        <?php foreach ($this->choices as $value => $label) : ?>
            <label id="input-search">
                <input type="radio" value="<?php echo esc_attr($value); ?>" name="<?php echo esc_attr($name); ?>" <?php $this->link();
                                                                                                                    checked($this->value(), $value); ?> style="display: none;">
                <img src="<?php echo esc_url($label); ?>" alt="<?php echo esc_attr($value); ?>" />
            </label>
        <?php endforeach; ?>
<?php
    }
}
