<?php
namespace app\widgets;

use Yii;
use yii\bootstrap\Widget;

class Alert extends Widget
{
    public $icones = [
        'success' => '<i class="fa fa-check"></i>',
        'error' => '<i class="fa fa-ban"></i>',
        'info' => '<i class="fa fa-info"></i>',
        'waring' => '<i class="fa fa-warning"></i>',
    ];

    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error' => 'alert-danger',
        'danger' => 'alert-danger',
        'success' => 'alert-success',
        'info' => 'alert-info',
        'warning' => 'alert-warning'
    ];

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public function init()
    {
        parent::init();

        $session = Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array)$data;
                foreach ($data as $message) {
                    /* initialize css class for each alert box */
                    $this->options['class'] = $this->alertTypes[$type] . $appendCss;

                    /* assign unique id to each alert box */
                    $this->options['id'] = $this->getId() . '-' . $type;

                    echo \yii\bootstrap\Alert::widget([
                        'body' => $this->renderIcon($type) . "\n" . $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                }

                $session->removeFlash($type);
            }
        }
    }

    public function renderIcon($type)
    {
        return isset($this->icones[$type]) ? $this->icones[$type] : '';
    }
}
