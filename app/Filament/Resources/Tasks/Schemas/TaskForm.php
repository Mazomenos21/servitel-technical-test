<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description'),
                Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Progreso',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                    ])
                    ->required()
                    ->default('pending'),
                Select::make('priority')
                    ->options([
                        1 => 'Baja',
                        2 => 'Media',
                        3 => 'Alta',
                    ])
                    ->required()
                    ->default(2),
                DatePicker::make('due_date'),
                TagsInput::make('tags')
                    ->placeholder('Agregar tag'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
