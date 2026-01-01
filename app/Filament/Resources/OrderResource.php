<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Phone;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function updateTotals(Get $get, Set $set)
    {
        $selectedPhones = collect($get('orderDetails'))->filter(fn($item)
        => !empty($item['phone_id']) && !empty($item['quantity']));

        $prices = Phone::find($selectedPhones->pluck('phone_id'))->pluck('price', 'id');

        $subtotal = $selectedPhones->reduce(function ($subtotal, $item) use ($prices) {
            return $subtotal + ($prices[$item['phone_id']] * $item['quantity']);
        }, 0);

        $tax_amount = round($subtotal * 0.11);

        $total_amount = round($subtotal + $tax_amount);

        $total_quantity = $selectedPhones->sum('quantity');

        $set('total_amount', number_format($total_amount, 0, '.', ''));

        $set('tax_amount', number_format($tax_amount, 0, '.', ''));

        $set('quantity', $total_quantity);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product and Price')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Add your product items')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Repeater::make('orderDetails')
                                        ->relationship('orderDetails')
                                        ->schema([
                                            Select::make('phone_id')
                                                ->relationship('phone', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->label('Select Phone')
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    $phone = Phone::find($state);
                                                    $set('price', $phone ? $phone->price : 0);
                                                }),

                                            TextInput::make('price')
                                                ->required()
                                                ->numeric()
                                                ->readOnly()
                                                ->label('Price')
                                                ->hint('Price will be filled automatically based on product selection'),

                                            TextInput::make('quantity')
                                                ->required()
                                                ->integer()
                                                ->default(1)
                                        ])
                                        ->live()
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            self::updateTotals($get, $set);
                                        })
                                        ->minItems(1)
                                        ->columnSpan('full')
                                        ->label('Choose Products')
                                ]),

                            Grid::make(3)
                                ->schema([
                                    TextInput::make('quantity')
                                        ->integer()
                                        ->label('Total Quantity')
                                        ->readOnly()
                                        ->default(1)
                                        ->required(),

                                    TextInput::make('total_amount')
                                        ->numeric()
                                        ->label('Total Amount')
                                        ->readOnly(),

                                    TextInput::make('tax_amount')
                                        ->numeric()
                                        ->label('Total Tax (11%)')
                                        ->readOnly(),
                                ])
                        ]),

                    Step::make('Customer Information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('For our marketing')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('phone')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('email')
                                        ->required()
                                        ->maxLength(255)

                                ])
                        ]),

                    Step::make('Delivery Information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Put your correct address')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('city')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('post_code')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('shipping_address')
                                        ->required()
                                        ->maxLength(255)

                                ])
                        ]),

                    Step::make('Payment Information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Review your payment')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('order_code')
                                        ->required()
                                        ->maxLength(255),

                                    ToggleButtons::make('is_paid')
                                        ->label('Apakah sudah membayar?')
                                        ->boolean()
                                        ->grouped()
                                        ->icons([
                                            true => 'heroicon-o-pencil',
                                            false => 'heroicon-o-clock',
                                        ])
                                        ->required(),

                                    FileUpload::make('payment_proof')
                                        ->required()
                                        ->image()

                                ])
                        ])

                ])
                    ->columnSpan('full')
                    ->columns(1)
                    ->skippable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('order_code')
                    ->searchable(),

                TextColumn::make('created_at'),

                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Terverifikasi')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (Order $record) {
                        $record->is_paid = true;
                        $record->save();

                        Notification::make()
                            ->title('Order Approved')
                            ->success()
                            ->body('The order has been successfully approved')
                            ->send();
                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Order $record) => !$record->is_paid)
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
