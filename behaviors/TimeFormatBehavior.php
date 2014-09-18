<?php
namespace app\behaviors;

use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

class TimeFormatBehavior extends AttributeBehavior
{
    public $attributes = [
        ActiveRecord::EVENT_BEFORE_INSERT => 'time',
        ActiveRecord::EVENT_BEFORE_UPDATE => 'time',
//        ActiveRecord::EVENT_AFTER_FIND => 'time'
    ];

    public $dateFormat = 'Y-m-d H:i:s';

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                $this->owner->$attribute = $this->getValue($event, $this->owner->$attribute);
            }
        }
    }

    protected function getValue($event, $value = null)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } elseif ($this->value !== null) {
            return call_user_func($this->value, $event);
        } elseif ($event->name == ActiveRecord::EVENT_AFTER_FIND) {
            return is_numeric($value) ? date($this->dateFormat, $value) : $value;
        } else {
            return is_numeric($value) ? $value : strtotime($value);
        }
    }
}