<?php

namespace Features\Media;

use Katyusha\Framework\Eloquent\Model;

/**
 * @property string name
 * @property string ogv
 * @property string webm
 * @property string mp4
 */
class Video extends Model {
    protected $table = 'media.videos';
}
