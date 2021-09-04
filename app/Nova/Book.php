<?php

namespace App\Nova;

use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Book extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Book::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            Text::make('Title')
                ->rules('required'),

            Text::make('Author')
                ->rules('required'),

            Select::make('Language')
                ->options([
                    'Filipino' => 'Filipino',
                    'English' => 'English',
                ]),

            Image::make('Cover')
                ->disk('nova')
                ->onlyOnDetail()
                ->disableDownload(),

            Select::make('Category')
                ->options([
                    'Novel' => 'Novel',
                    'Illustrated Novel' => 'Illustrated Novel',
                    'Comic Book' => 'Comic Book',
                    'Anthology' => 'Anthology',
                    'Picture Book' => 'Picture Book',
                ])
                ->required(),

            Select::make('Genre')
                ->options(Genre::get()->pluck('name', 'name')),

            Text::make('Publish Date', 'publish_date'),

            Select::make('Lead College')
                ->options([
                    'Integrated School' => 'Integrated School',
                    'Berkeley' => 'Berkeley',
                    'Reagan' => 'Reagan',
                    'Non-BRU' => 'Non-BRU',
                ])
                ->required(),

            Textarea::make('Blurb')
                ->rules('required'),

            Textarea::make('Credit Page')
                ->rules('required'),

            HasMany::make('Chapters'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static $group = 'Works Management';
}
