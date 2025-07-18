<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $modelLabel = 'User';
    protected static ?string $pluralModelLabel = 'Users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(255)
                ->placeholder('Enter user full name'),

            Forms\Components\TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->placeholder('user@example.com'),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                ->dehydrated(fn ($state) => filled($state))
                ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                ->autocomplete('new-password')
                ->placeholder('********'),

            Forms\Components\Select::make('roles')
                ->label('Assign Roles')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->native(false)
                ->searchable()
                ->required(),
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
                    ->label('Full Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('roles.name')
                    ->label('Roles')
                    ->colors([
                        'primary' => 'admin',
                        'info' => 'user',
                    ])
                    ->separator(', ')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->tooltip('Edit User'),
                Tables\Actions\DeleteAction::make()->tooltip('Delete User'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
