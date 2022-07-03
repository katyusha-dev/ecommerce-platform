<?php

namespace App\Nova;

use Naif\Toggle\Toggle;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Field;
use Sixlive\TextCopy\TextCopy;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Comodolab\Nova\Fields\Help\Help;
use Vyuldashev\NovaMoneyField\Money;
use Laraning\NovaTimeField\TimeField;
use GeneaLabs\NovaGutenberg\Gutenberg;
use Nsavinov\NovaPercentField\Percent;
use R64\NovaImageCropper\ImageCropper;
use KirschbaumDevelopment\Nova\InlineSelect;
use MarkRassamni\InlineBoolean\InlineBoolean;
use Silvanite\NovaFieldCheckboxes\Checkboxes;
use Benjacho\BelongsToManyField\BelongsToManyField;
use BrilliantPackages\NovaRelationshipsLinkList\RelationshipsLinkList;

final class Fields {
    protected array $fields = [];

    public function __construct(...$fields) {
        foreach ($fields as $field) {
            $this->fields[] = $field;
        }
    }

    protected static function _(...$fields): self {
        return new self(...$fields);
    }

    protected function generateFields(string $class, ...$keys): self {
        foreach ($keys as $key) {
            if (is_array($key)) {
                $key   = array_keys($key)[0];
                $label = $keys[$key];
            } else {
                $label = self::label($key);
            }

            $this->fields[] = $this->generateField($class, $label, $key);
        }

        return $this;
    }

    protected function generateField(string $class, string $label, string $key): Field {
        assert($class instanceof Field);
        $field = null;


        if ($class == Money::class) {
            $field = Money::make($label, 'NOK', $key);
        }

        if (!$field) {
            $field = $class::make($label, $key);
        }

        return $field;
    }

    public static function label(string $key): string {
        return ucwords(str_replace('_', ' ', $key));
    }

    public function toArray(): array {
        return $this->fields;
    }

    public static function text(...$keys): self {
        return self::_()->generateFields(Text::class, ...$keys);
    }

    public static function textCopy(...$keys): self {
        return self::_()->generateFields(TextCopy::class, ...$keys);
    }

    public static function code(...$keys): self {
        return self::_()->generateFields(Code::class, ...$keys);
    }

    public static function time(...$keys): self {
        return self::_()->generateFields(TimeField::class, ...$keys);
    }

    public static function number(...$keys): self {
        return self::_()->generateFields(Number::class, ...$keys);
    }

    public static function money(...$keys): self {
        return self::_()->generateFields(Money::class, ...$keys);
    }

    public static function dateTime(...$keys): self {
        return self::_()->generateFields(DateTime::class, ...$keys);
    }

    public static function bool(string ...$keys): self {
        $fields = [];
        foreach ($keys as $key) {
            $fields[] = InlineBoolean::make(self::label($key), $key)->inlineOnIndex(true)->onlyOnIndex();
            $fields[] = Toggle::make(self::label($key), $key)->hideFromIndex();
        }

        return self::_(...$fields);
    }

    public static function help(string $title, string $message): Help {
        return Help::make($title, $message);
    }

    public static function heading(string $title): Heading {
        return Heading::make($title);
    }

    public static function checkboxes(string $key, array $options): Checkboxes {
        return Checkboxes::make(self::label($key), $key)->options($options)->columns(3)->withoutTypeCasting();
    }

    public static function content(string $key): Gutenberg {
        return Gutenberg::make(self::label($key), $key)->hideFromIndex();
    }

    public static function percent(string $key): Percent {
        return Percent::make(self::label($key), $key)->storedInDecimal(false);
    }

    public static function image(string $key, string $disk, ?float $ratio = null): ImageCropper {
        return ImageCropper::make(self::label($key), $key)->disk($disk)->aspectRatio($ratio);
    }

    public static function relationLinksList(string $key): RelationshipsLinkList {
        return RelationshipsLinkList::make(self::label($key), $key);
    }

    public static function select(string $key, array $options): array {
        return [
            Select::make(self::label($key), $key)->displayUsingLabels()->options($options)->onlyOnForms(),
            InlineSelect::make(self::label($key), $key)->options($options)->inlineOnIndex()->inlineOnDetail()->exceptOnForms()
        ];
    }

    public static function belongsTo(string $key, string $novaRelation): BelongsTo {
        return BelongsTo::make(self::label($key), $key, $novaRelation)->searchable()->debounce(100)->withoutTrashed()->showCreateRelationButton();
    }

    public static function belongsToMany(string $key, string $novaRelation, ?string $optionsLabel = 'name'): BelongsToManyField {
        return BelongsToManyField::make(self::label($key), $key, $novaRelation)->optionsLabel($optionsLabel);
    }

    public static function hasMany(string $key, string $novaRelation): HasMany {
        return HasMany::make(self::label($key), $key, $novaRelation);
    }

    public static function hasOne(string $key, string $novaRelation): HasOne {
        return HasOne::make(self::label($key), $key, $novaRelation);
    }
}
