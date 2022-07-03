<?php

namespace App\Nova;

use function str_replace;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Mostafaznv\NovaVideo\Video;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Yassi\NestedForm\NestedForm;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Mostafaznv\NovaVideo\VideoMeta;
use Halimtuhu\ArrayImages\ArrayImages;
use Laravel\Nova\Fields\BelongsToMany;
use PixelCreation\NovaFieldSortable\Sortable;
use Marshmallow\NovaFontAwesome\NovaFontAwesome;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;

class Form {
    protected $fields = [];

    public function __construct(protected Request $request) {
    }

    public static function make(Request $request): self {
        return new self($request);
    }

    public function add(mixed $field): self {
        $this->fields[] = $field;

        return $this;
    }

    public function toArray(): array {
        return $this->fields;
    }

    protected function key(string $title): string {
        return mb_strtolower(str_replace(' ', '_', $title));
    }

    public function inlineHasMany(string $title, string $relationClass): self {
        $this->fields[] = NestedForm::make($title, $this->key($title), $relationClass);

        return $this;
    }

    public function hasMany(string $title, string $relationClass): self {
        $this->fields[] = HasMany::make($title, $this->key($title), $relationClass);

        return $this;
    }

    public function belongsTo(string $title, string $relationClass, ?bool $nullable = false): self {
        $this->fields[] = BelongsTo::make($title, $this->key($title), $relationClass)->nullable($nullable);

        return $this;
    }

    public function belongsToMany(string $title, string $relationClass, ?bool $nullable = false, ?string $key = null): self {
        $this->fields[] = BelongsToMany::make($title, $key ?: $this->key($title), $relationClass)->nullable($nullable);

        return $this;
    }

    public function email(string $title, ?bool $required = false): self {
        $this->fields[] = Text::make($title, $this->key($title))->required($required);

        return $this;
    }

    public function text(string $title, ?bool $required = false): self {
        $this->fields[] = Text::make($title, $this->key($title))->required($required);

        return $this;
    }

    public function url(string $title): self {
        $this->fields[] = Text::make($title, $this->key($title));

        return $this;
    }

    public function textarea(string $title): self {
        $this->fields[] = Textarea::make($title, $this->key($title));

        return $this;
    }

    public function code(string $title): self {
        $this->fields[] = Code::make($title, $this->key($title));

        return $this;
    }

    public function bool(string $title): self {
        $this->fields[] = Boolean::make($title, $this->key($title));

        return $this;
    }

    public function gallery(string $title): self {
        $this->fields[] = ArrayImages::make($title, $this->key($title))->disk('media');


        return $this;
    }

    public function video(string $title, bool $nullable): self {
        $this->fields[] = Video::make(trans('Video'), 'videos')
            ->rules('file', 'max:150000', 'mimes:mp4', 'mimetypes:video/mp4')
            ->storeWithLarupload('video')
            ->creationRules('required')
            ->updateRules('nullable');

        $this->fields[] = [...VideoMeta::make('video')->all()];

        return $this;
    }

    public function image(string $title): self {
        $this->fields[] = Image::make($title, $this->key($title), 'media');

        return $this;
    }

    public function file(string $title, string $disk = 'media'): self {
        $this->fields[] = File::make($title, $this->key($title), $disk);

        return $this;
    }

    public function integer(string $title, ?bool $required = false): self {
        $this->fields[] = Number::make($title, $this->key($title))->required($required);

        return $this;
    }

    public function icon(string $title): self {
        $this->fields[] = NovaFontAwesome::make($title, $this->key($title))->pro();

        return $this;
    }

    public function sortable(): self {
        $this->fields[] =   Sortable::make('Order', 'sort_order')->onlyOnIndex();

        return $this;
    }

    public function money(string $title): self {
        $this->fields[] = Currency::make($title, $this->key($title))->currency('NOK');

        return $this;
    }

    public function mediaLibrary(string $name, string $collection, bool $single = false, string $diskName = 'media'): self {
        $field = Medialibrary::make($name, $collection, $diskName)->previewUsing(fn (Media $media) => $media->getFullUrl('preview'))->attachOnDetails()->autouploading()->sortable()->mediaOnIndex(1);

        if ($single) {
            $field->single();
        }

        $this->fields[] = $field;

        return $this;
    }
}
