<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Phone;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->image()
                    ->required()
                    ->directory('banners'),
                Grid::make(2)->schema([
                    Select::make('link_type')
                        ->label('Banner Target')
                        ->options([
                            'brand' => 'Brand',
                            'phone' => 'Product',
                            'category' => 'Category',
                            'custom' => 'Custom URL',
                        ])
                        ->required()
                        ->live(),

                    Select::make('link_slug')
                        ->label('Target Data')
                        ->options(fn(Get $get) => match ($get('link_type')) {
                            'brand' => Brand::pluck('name', 'slug'),
                            'phone' => Phone::pluck('name', 'slug'),
                            'category' => Category::pluck('name', 'slug'),
                            default => [],
                        })
                        ->searchable()
                        ->visible(
                            fn(Get $get) =>
                            in_array($get('link_type'), ['brand', 'phone', 'category'])
                        )
                        ->required(
                            fn(Get $get) =>
                            in_array($get('link_type'), ['brand', 'phone', 'category'])
                        ),

                    TextInput::make('custom_link')
                        ->label('Custom URL')
                        ->url()
                        ->placeholder('https://example.com')
                        ->visible(fn(Get $get) => $get('link_type') === 'custom')
                        ->required(fn(Get $get) => $get('link_type') === 'custom'),
                ]),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Banner')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('link_type')
                    ->badge(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
