<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ProductResource\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $pluralModelLabel = 'Products';
    protected static ?string $modelLabel = 'Product';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Product Name')
                ->required()
                ->maxLength(255)
                ->placeholder('e.g. iPhone 15'),

            Forms\Components\TextInput::make('price')
                ->label('Price ($)')
                ->numeric()
                ->required()
                ->prefix('$'),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'available' => 'Available',
                    'out_of_stock' => 'Out of Stock',
                ])
                ->required()
                ->native(false)
                ->searchable(),

            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->rows(4)
                ->maxLength(1000)
                ->placeholder('Write a brief product description...'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('usd', true)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'available' => 'success',
                        'out_of_stock' => 'danger',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Edit Product'),

                Tables\Actions\DeleteAction::make()
                    ->tooltip('Delete Product'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
