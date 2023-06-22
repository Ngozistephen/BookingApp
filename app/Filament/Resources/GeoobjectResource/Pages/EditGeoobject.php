<?php

namespace App\Filament\Resources\GeoobjectResource\Pages;

use App\Filament\Resources\GeoobjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeoobject extends EditRecord
{
    protected static string $resource = GeoobjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
